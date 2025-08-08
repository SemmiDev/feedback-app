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

        $user = auth()->user();
        $query = Feedback::query();

        // If user is penceramah, filter by their ID
        if ($user->isPenceramah()) {
            $query->where('imapp_id_penceramah', $user->id_penceramah);
        } else if($user->isPengurusMasjid()) {
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
}
