<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\SentimentAnalysis;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        // Set timezone for all Carbon instances in this request
        Carbon::setToStringFormat('Y-m-d H:i:s');

        $user = auth()->user();
        $query = Feedback::query();

        // If user is penceramah, filter by their ID
        if ($user->isPenceramah()) {
            $query->where('imapp_id_penceramah', $user->id_penceramah);
        } else if ($user->isPengurusMasjid()) {
            $query->where('imapp_id_masjid', $user->id_masjid);
        }

        // Get statistics
        $totalFeedbacks = $query->count();

        // Calculate average ratings for each category
        $averageRatings = [
            'relevansi' => $query->avg('relevansi_rating') ?? 0,
            'kejelasan' => $query->avg('kejelasan_rating') ?? 0,
            'pemahaman_jamaah' => $query->avg('pemahaman_jamaah_rating') ?? 0,
            'kesesuaian_waktu' => $query->avg('kesesuaian_waktu_rating') ?? 0,
            'interaksi_jamaah' => $query->avg('interaksi_jamaah_rating') ?? 0,
        ];

        $recentFeedbacks = (clone $query)->recent(7)->count();

        // Get rating distribution for each rating type
        $ratingFields = [
            'relevansi_rating' => 'Relevansi Materi',
            'kejelasan_rating' => 'Kejelasan Penyampaian',
            'pemahaman_jamaah_rating' => 'Pemahaman Jamaah',
            'kesesuaian_waktu_rating' => 'Kesesuaian Waktu',
            'interaksi_jamaah_rating' => 'Interaksi Jamaah',
        ];

        $ratingDistribution = [];
        foreach ($ratingFields as $field => $label) {
            $distribution = (clone $query)->select($field, DB::raw('count(*) as count'))
                ->groupBy($field)
                ->orderBy($field)
                ->get()
                ->pluck('count', $field)
                ->toArray();

            // Fill missing ratings with 0
            for ($i = 1; $i <= 5; $i++) {
                if (!isset($distribution[$i])) {
                    $distribution[$i] = 0;
                }
            }
            ksort($distribution);
            $ratingDistribution[$field] = [
                'label' => $label,
                'data' => $distribution,
            ];
        }

        // Get recent feedbacks for display
        $latestFeedbacks = (clone $query)->latest()->take(5)->get();

        // Monthly feedback trend (last 6 months) - convert to WIB for display
        $monthlyTrend = (clone $query)->select(
            DB::raw('YEAR(CONVERT_TZ(created_at, "+00:00", "+07:00")) as year'),
            DB::raw('MONTH(CONVERT_TZ(created_at, "+00:00", "+07:00")) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('dashboard.index', compact(
            'totalFeedbacks',
            'averageRatings',
            'recentFeedbacks',
            'ratingDistribution',
            'latestFeedbacks',
            'monthlyTrend'
        ));
    }

    public function sentimen(Request $request)
    {
        // Get sentiment statistics
        $totalSentiments = SentimentAnalysis::count();

        // Sentiment distribution
        $sentimentDistribution = SentimentAnalysis::select('sentiment_label', DB::raw('count(*) as count'))
            ->groupBy('sentiment_label')
            ->get()
            ->pluck('count', 'sentiment_label')
            ->toArray();

        // Average sentiment score
        $averageSentimentScore = SentimentAnalysis::avg('sentiment_score') ?? 0;

        // Get sentiment by score ranges
        $scoreRanges = [
            'negative' => SentimentAnalysis::where('sentiment_label', 'LIKE', '%negative%')->count(),
            'neutral' => SentimentAnalysis::where('sentiment_label', 'LIKE', '%neutral%')->count(),
            'positive' => SentimentAnalysis::where('sentiment_label', 'LIKE', '%positive%')->count(),
        ];

        // Monthly sentiment trend (last 6 months)
        $monthlySentimentTrend = SentimentAnalysis::select(
            DB::raw('YEAR(CONVERT_TZ(created_at, "+00:00", "+07:00")) as year'),
            DB::raw('MONTH(CONVERT_TZ(created_at, "+00:00", "+07:00")) as month'),
            'sentiment_label',
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month', 'sentiment_label')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Recent sentiments for display
        // $latestSentiments = SentimentAnalysis::paginate(50);

        // Top positive and negative sentiments
        $topPositive = SentimentAnalysis::where('sentiment_label', 'LIKE', '%positif%')
            ->orWhere('sentiment_label', 'LIKE', '%positive%')
            ->orderBy('sentiment_score', 'desc')
            ->take(25)
            ->get();

        $topNeutral = SentimentAnalysis::where('sentiment_label', 'LIKE', '%neutral%')
            ->orWhere('sentiment_label', 'LIKE', '%neutral%')
            ->orderBy('sentiment_score', 'asc')
            ->take(25)
            ->get();

        $topNegative = SentimentAnalysis::where('sentiment_label', 'LIKE', '%negatif%')
            ->orWhere('sentiment_label', 'LIKE', '%negative%')
            ->orderBy('sentiment_score', 'asc')
            ->take(25)
            ->get();

        return view('dashboard.sentiment', compact(
            'totalSentiments',
            'sentimentDistribution',
            'averageSentimentScore',
            'scoreRanges',
            'monthlySentimentTrend',
            // 'latestSentiments',
            'topPositive',
            'topNeutral',
            'topNegative'
        ));
    }

    public function uploadSentimen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'File yang diupload harus berformat CSV dan maksimal 10MB');
        }

        try {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();

            // Clear existing data
            SentimentAnalysis::truncate();

            // Read CSV file
            if (($handle = fopen($path, 'r')) !== FALSE) {
                $header = fgetcsv($handle, 1000, ',');

                // Validate CSV structure
                $expectedHeaders = ['saran', 'clean_text', 'sentiment_label', 'sentiment_score'];
                $headerMap = [];

                foreach ($expectedHeaders as $expectedHeader) {
                    $index = array_search($expectedHeader, $header);
                    if ($index === false) {
                        fclose($handle);
                        return redirect()->back()
                            ->with('error', "Kolom '$expectedHeader' tidak ditemukan dalam file CSV");
                    }
                    $headerMap[$expectedHeader] = $index;
                }

                $insertData = [];
                $rowCount = 0;

                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $rowCount++;

                    // Skip empty rows
                    if (empty(array_filter($data))) {
                        continue;
                    }

                    $insertData[] = [
                        'saran' => $data[$headerMap['saran']] ?? '',
                        'clean_text' => $data[$headerMap['clean_text']] ?? '',
                        'sentiment_label' => $data[$headerMap['sentiment_label']] ?? '',
                        'sentiment_score' => (float) ($data[$headerMap['sentiment_score']] ?? 0),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Insert in batches of 100
                    if (count($insertData) >= 100) {
                        SentimentAnalysis::insert($insertData);
                        $insertData = [];
                    }
                }

                // Insert remaining data
                if (!empty($insertData)) {
                    SentimentAnalysis::insert($insertData);
                }

                fclose($handle);

                return redirect()->route('dashboard.sentiment')
                    ->with('success', "Berhasil mengupload dan memproses $rowCount data sentimen");
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal membaca file CSV');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }
}
