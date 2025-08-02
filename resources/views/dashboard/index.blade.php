@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
        <p class="text-gray-600">Welcome back! Here's what's happening with your feedback.</p>
        <p class="text-sm text-gray-500 mt-1">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Last updated: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Feedbacks -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-emerald-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Feedbacks</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($totalFeedbacks) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Rating -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Average Rating</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($averageRating, 1) }}/5</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Feedbacks -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">This Week</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($recentFeedbacks) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Satisfaction Rate -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Satisfaction</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ $totalFeedbacks > 0 ? number_format(((($ratingDistribution[4] ?? 0) + ($ratingDistribution[5] ?? 0)) / $totalFeedbacks) * 100, 1) : 0 }}%
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Rating Distribution Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Rating Distribution</h3>
                <div class="relative h-64">
                    <canvas id="ratingChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Trend Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Monthly Trend</h3>
                <div class="relative h-64">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Feedbacks -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Feedbacks</h3>
                <a href="{{ route('dashboard.feedbacks.index') }}" class="text-sm text-emerald-600 hover:text-emerald-500">
                    View all →
                </a>
            </div>

            @if ($latestFeedbacks->count() > 0)
                <div class="space-y-4">
                    @foreach ($latestFeedbacks as $feedback)
                        <div class="border-l-4 border-blue-400 pl-4 py-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                            <span
                                                class="text-sm font-medium text-gray-700">{{ substr($feedback->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $feedback->name }}</p>
                                        <div class="flex items-center space-x-1">
                                            <span class="{{ $feedback->rating_color }}">{{ $feedback->stars }}</span>
                                            <span
                                                class="text-xs text-gray-500">{{ $feedback->created_at_for_humans }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500">{{ $feedback->formatted_date }}</div>
                                    <div class="text-xs text-gray-400">{{ $feedback->formatted_time }}</div>
                                    <a href="{{ route('dashboard.feedbacks.show', $feedback) }}"
                                        class="text-emerald-600 hover:text-emerald-500 text-sm font-medium px-3 py-1 rounded transition-colors"
                                        style="background-color: #d1fae5;">
                                        View
                                    </a>
                                </div>
                            </div>
                            @if ($feedback->comment)
                                <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $feedback->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No feedbacks yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by sharing your feedback form with users.</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            // Rating Distribution Chart
            const ratingCtx = document.getElementById('ratingChart').getContext('2d');
            const ratingChart = new Chart(ratingCtx, {
                type: 'doughnut',
                data: {
                    labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
                    datasets: [{
                        data: @json(array_values($ratingDistribution)),
                        backgroundColor: [
                            '#EF4444', // red-500
                            '#F97316', // orange-500
                            '#EAB308', // yellow-500
                            '#22C55E', // green-500
                            '#10B981' // emerald-500
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Monthly Trend Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const monthlyData = @json($monthlyTrend);

            // Prepare data for the last 6 months (in WIB timezone)
            const months = [];
            const counts = [];
            const now = new Date();

            for (let i = 5; i >= 0; i--) {
                const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
                const monthName = date.toLocaleDateString('id-ID', {
                    month: 'short',
                    year: 'numeric'
                });
                months.push(monthName);

                const monthData = monthlyData.find(item =>
                    item.year === date.getFullYear() && item.month === (date.getMonth() + 1)
                );
                counts.push(monthData ? monthData.count : 0);
            }

            const trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Feedbacks',
                        data: counts,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
