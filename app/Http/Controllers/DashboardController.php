<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Set timezone for all Carbon instances in this request
        Carbon::setToStringFormat('Y-m-d H:i:s');

        // Get statistics
        $totalFeedbacks = Feedback::count();

        // Calculate average ratings for each category
        $averageRatings = [
            'relevansi' => Feedback::avg('relevansi_rating') ?? 0,
            'kejelasan' => Feedback::avg('kejelasan_rating') ?? 0,
            'pemahaman_jamaah' => Feedback::avg('pemahaman_jamaah_rating') ?? 0,
            'kesesuaian_waktu' => Feedback::avg('kesesuaian_waktu_rating') ?? 0,
            'interaksi_jamaah' => Feedback::avg('interaksi_jamaah_rating') ?? 0,
        ];

        $recentFeedbacks = Feedback::recent(7)->count();

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
            $distribution = Feedback::select($field, DB::raw('count(*) as count'))
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
        $latestFeedbacks = Feedback::latest()->take(5)->get();

        // Monthly feedback trend (last 6 months) - convert to WIB for display
        $monthlyTrend = Feedback::select(
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
}
