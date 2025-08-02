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
        $averageRating = Feedback::avg('rating');
        $recentFeedbacks = Feedback::recent(7)->count();

        // Get rating distribution
        $ratingDistribution = Feedback::select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->get()
            ->pluck('count', 'rating')
            ->toArray();

        // Fill missing ratings with 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }
        ksort($ratingDistribution);

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
            'averageRating',
            'recentFeedbacks',
            'ratingDistribution',
            'latestFeedbacks',
            'monthlyTrend'
        ));
    }
}
