@extends('layouts.dashboard')

@section('title', 'Analisis Sentimen')

@section('styles')
    <style>
        /* Tambahkan CSS ini ke dalam file resources/css/app.css atau buat file terpisah */

        /* Sentiment Analysis Dashboard Styles */
        .sentiment-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .sentiment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Progress bars for sentiment distribution */
        .sentiment-progress {
            transition: width 0.8s ease-in-out;
            animation: progressLoad 1s ease-out;
        }

        @keyframes progressLoad {
            from {
                width: 0%;
            }
        }

        /* Modal backdrop blur effect */
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }

        /* File upload hover effect */
        .file-upload:hover {
            background-color: #f8fafc;
            border-color: #3b82f6;
        }

        /* Sentiment badges */
        .sentiment-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 500;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            transition: all 0.2s ease-in-out;
        }

        .sentiment-badge:hover {
            transform: scale(1.05);
        }

        /* Sentiment positive */
        .sentiment-positive {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        /* Sentiment negative */
        .sentiment-negative {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Sentiment neutral */
        .sentiment-neutral {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* Table row hover effect */
        .table-row-hover:hover {
            background-color: #f9fafb;
            transform: translateX(2px);
            transition: all 0.2s ease-in-out;
        }

        /* Chart containers */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Loading animation for upload */
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Fade in animation for cards */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar for tables */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }

            .sentiment-card {
                margin-bottom: 1rem;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }

        /* Dark mode support (optional) */
        @media (prefers-color-scheme: dark) {
            .sentiment-card {
                background-color: #1f2937;
                border-color: #374151;
            }

            .sentiment-positive {
                background-color: #064e3b;
                color: #6ee7b7;
                border-color: #047857;
            }

            .sentiment-negative {
                background-color: #7f1d1d;
                color: #fca5a5;
                border-color: #dc2626;
            }

            .sentiment-neutral {
                background-color: #78350f;
                color: #fcd34d;
                border-color: #f59e0b;
            }
        }

        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }

            .sentiment-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }

        /* Additional utility classes */
        .text-shadow {
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Toast notification styles (if needed) */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #10b981;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: slideInRight 0.3s ease-out;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Analisis Sentimen</h1>
                <p class="text-gray-600">Dashboard untuk menganalisis sentimen feedback pengguna</p>
                <p class="text-sm text-gray-500 mt-1">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Terakhir diperbarui: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                </p>
            </div>
            <div>
                <button onclick="openUploadModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                    Upload CSV
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Sentiments -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Data Sentimen</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($totalSentiments) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <!-- Average Sentiment Score -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rata-rata Skor</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($averageSentimentScore, 3) }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sentiment Health -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 h-8 {{ $averageSentimentScore >= 0 ? 'bg-green-500' : 'bg-red-500' }} rounded-md flex items-center justify-center">
                            @if ($averageSentimentScore >= 0)
                                <span class="text-white">😊</span>
                            @else
                                <span class="text-white">😞</span>
                            @endif
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Status Sentimen</dt>
                            <dd
                                class="text-lg font-medium {{ $averageSentimentScore >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $averageSentimentScore >= 0.2 ? 'Sangat Positif' : ($averageSentimentScore >= 0 ? 'Positif' : ($averageSentimentScore >= -0.2 ? 'Netral' : 'Negatif')) }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sentiment Distribution and Score Range -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Sentiment Distribution Pie Chart -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Distribusi Sentimen</h3>
                <div class="relative h-64">
                    <canvas id="sentimentPieChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-4 text-center">
                    @foreach ($sentimentDistribution as $label => $count)
                        <div class="bg-gray-50 p-3 rounded">
                            <div class="text-2xl mb-1">
                                @if (strpos(strtolower($label), 'positif') !== false || strpos(strtolower($label), 'positive') !== false)
                                    😊
                                @elseif(strpos(strtolower($label), 'negatif') !== false || strpos(strtolower($label), 'negative') !== false)
                                    😞
                                @else
                                    😐
                                @endif
                            </div>
                            <div class="text-sm font-medium text-gray-900">{{ ucfirst($label) }}</div>
                            <div class="text-sm text-gray-600">{{ number_format($count) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Score Range Distribution -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Distribusi Skor Sentimen</h3>
                <div class="space-y-4">
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-red-500">Negatif</span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-red-400 h-2 rounded-full"
                                    style="width: {{ $totalSentiments > 0 ? ($scoreRanges['negative'] / $totalSentiments) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm text-gray-900 w-8">{{ $scoreRanges['negative'] }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-yellow-600">Netral</span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-yellow-400 h-2 rounded-full"
                                    style="width: {{ $totalSentiments > 0 ? ($scoreRanges['neutral'] / $totalSentiments) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm text-gray-900 w-8">{{ $scoreRanges['neutral'] }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-green-500">Positif</span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-green-400 h-2 rounded-full"
                                    style="width: {{ $totalSentiments > 0 ? ($scoreRanges['positive'] / $totalSentiments) * 100 : 0 }}%">
                                </div>
                            </div>
                            <span class="text-sm text-gray-900 w-8">{{ $scoreRanges['positive'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Sentiment Trend -->
    {{-- <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tren Sentimen Bulanan</h3>
            <div class="relative h-64">
                <canvas id="sentimentTrendChart"></canvas>
            </div>
        </div>
    </div> --}}

    <!-- Top Positive and Negative Sentiments -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Top Positive -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 flex items-center">
                    <span class="text-green-600 mr-2">😊</span>
                    Top Sentimen Positif
                </h3>
                @if ($topPositive->count() > 0)
                    <div class="space-y-3">
                        @foreach ($topPositive as $sentiment)
                            <div class="border-l-4 border-green-400 pl-4 py-2 bg-green-50">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm text-gray-700 flex-1">{{ Str::limit($sentiment->saran, 100) }}</p>
                                    <span class="text-xs font-medium text-green-600 ml-2 bg-green-100 px-2 py-1 rounded">
                                        {{ number_format($sentiment->sentiment_score, 3) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        Belum ada data sentimen positif
                    </div>
                @endif
            </div>
        </div>

         <!-- Top Positive -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 flex items-center">
                    <span class="text-green-600 mr-2">😊</span>
                    Top Sentimen Netral
                </h3>
                @if ($topNeutral->count() > 0)
                    <div class="space-y-3">
                        @foreach ($topNeutral as $sentiment)
                            <div class="border-l-4 border-green-400 pl-4 py-2 bg-green-50">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm text-gray-700 flex-1">{{ Str::limit($sentiment->saran, 100) }}</p>
                                    <span class="text-xs font-medium text-green-600 ml-2 bg-green-100 px-2 py-1 rounded">
                                        {{ number_format($sentiment->sentiment_score, 3) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        Belum ada data sentimen positif
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Negative -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 flex items-center">
                    <span class="text-red-600 mr-2">😞</span>
                    Top Sentimen Negatif
                </h3>
                @if ($topNegative->count() > 0)
                    <div class="space-y-3">
                        @foreach ($topNegative as $sentiment)
                            <div class="border-l-4 border-red-400 pl-4 py-2 bg-red-50">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm text-gray-700 flex-1">{{ Str::limit($sentiment->saran, 100) }}</p>
                                    <span class="text-xs font-medium text-red-600 ml-2 bg-red-100 px-2 py-1 rounded">
                                        {{ number_format($sentiment->sentiment_score, 3) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        Belum ada data sentimen negatif
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Data Sentimen</h3>
                @if ($totalSentiments > 10)
                    <span class="text-sm text-gray-500">
                        Terdapat {{ number_format($totalSentiments) }} Data</span>
                @endif
            </div>

            @if ($latestSentiments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Feedback
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sentimen
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Skor
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($latestSentiments as $sentiment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ Str::limit($sentiment->saran, 60) }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($sentiment->clean_text, 40) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sentiment->sentiment_color }}">
                                            {{ $sentiment->sentiment_icon }} {{ ucfirst($sentiment->sentiment_label) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-mono">{{ number_format($sentiment->sentiment_score, 4) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $sentiment->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data sentimen</h3>
                    <p class="mt-1 text-sm text-gray-500">Upload file CSV untuk mulai menganalisis sentimen.</p>
                    <div class="mt-6">
                        <button onclick="openUploadModal()" type="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            Upload CSV
                        </button>
                    </div>
                </div>
            @endif
        </div>
           <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $latestSentiments->links() }}
        </div>
    </div> --}}

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Upload File CSV Sentimen</h3>
                    <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.sentiment.upload') }}" method="POST" enctype="multipart/form-data"
                    id="uploadForm">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            File CSV
                        </label>
                        <input type="file" name="csv_file" accept=".csv,.txt" required
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">
                            Format: CSV dengan kolom saran, clean_text, sentiment_label, sentiment_score
                        </p>
                    </div>

                    <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Perhatian:</strong> Upload file baru akan menghapus semua data sentimen yang ada
                                    sebelumnya.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeUploadModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Modal functions
            function openUploadModal() {
                document.getElementById('uploadModal').classList.remove('hidden');
            }

            function closeUploadModal() {
                document.getElementById('uploadModal').classList.add('hidden');
            }

            // Sentiment Distribution Pie Chart
            const sentimentPieCtx = document.getElementById('sentimentPieChart').getContext('2d');
            const sentimentDistribution = @json($sentimentDistribution);

            const pieLabels = Object.keys(sentimentDistribution);
            const pieData = Object.values(sentimentDistribution);
            const pieColors = pieLabels.map(label => {
                const lowerLabel = label.toLowerCase();
                if (lowerLabel.includes('positif') || lowerLabel.includes('positive')) {
                    return '#10B981';
                } else if (lowerLabel.includes('negatif') || lowerLabel.includes('negative')) {
                    return '#EF4444';
                } else {
                    return '#F59E0B';
                }
            });

            const sentimentPieChart = new Chart(sentimentPieCtx, {
                type: 'doughnut',
                data: {
                    labels: pieLabels.map(label => label.charAt(0).toUpperCase() + label.slice(1)),
                    datasets: [{
                        data: pieData,
                        backgroundColor: pieColors,
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
                                padding: 15,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Monthly Sentiment Trend Chart
            const trendCtx = document.getElementById('sentimentTrendChart').getContext('2d');
            const monthlyTrendData = @json($monthlySentimentTrend);

            // Prepare data for the last 6 months
            const months = [];
            const positiveData = [];
            const negativeData = [];
            const neutralData = [];

            const now = new Date();
            for (let i = 5; i >= 0; i--) {
                const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
                const monthName = date.toLocaleDateString('id-ID', {
                    month: 'short',
                    year: 'numeric'
                });
                months.push(monthName);

                // Find data for this month
                const monthData = monthlyTrendData.filter(item =>
                    item.year === date.getFullYear() && item.month === (date.getMonth() + 1)
                );

                let positive = 0,
                    negative = 0,
                    neutral = 0;
                monthData.forEach(item => {
                    const label = item.sentiment_label.toLowerCase();
                    if (label.includes('positif') || label.includes('positive')) {
                        positive += item.count;
                    } else if (label.includes('negatif') || label.includes('negative')) {
                        negative += item.count;
                    } else {
                        neutral += item.count;
                    }
                });

                positiveData.push(positive);
                negativeData.push(negative);
                neutralData.push(neutral);
            }

            const sentimentTrendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Positif',
                        data: positiveData,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    }, {
                        label: 'Negatif',
                        data: negativeData,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    }, {
                        label: 'Netral',
                        data: neutralData,
                        borderColor: '#F59E0B',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
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

            // Form validation
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                const fileInput = this.querySelector('input[type="file"]');
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Silakan pilih file CSV terlebih dahulu.');
                    return false;
                }

                const file = fileInput.files[0];
                if (!file.name.toLowerCase().endsWith('.csv')) {
                    e.preventDefault();
                    alert('File harus berformat CSV.');
                    return false;
                }

                // Show loading state
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.textContent = 'Mengupload...';
                submitButton.disabled = true;
            });
        </script>
    @endpush
@endsection


@push('scripts')
    <script>
        // Sentiment Dashboard JavaScript Functions
        // Tambahkan ke file resources/js/sentiment.js atau langsung di blade template

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dashboard
            initializeSentimentDashboard();
        });

        function initializeSentimentDashboard() {
            // Add fade-in animation to cards
            animateCards();

            // Setup file upload drag and drop
            setupFileUpload();

            // Setup tooltips
            setupTooltips();

            // Setup auto-refresh (optional)
            // setupAutoRefresh();
        }

        function animateCards() {
            const cards = document.querySelectorAll('.sentiment-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fade-in');
                }, index * 100);
            });
        }

        function setupFileUpload() {
            const fileInput = document.querySelector('input[type="file"]');
            const uploadArea = fileInput?.parentElement;

            if (!uploadArea) return;

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });

            uploadArea.addEventListener('drop', handleDrop, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight(e) {
                uploadArea.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight(e) {
                uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    updateFileName(files[0].name);
                }
            }

            // File selection handler
            fileInput?.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    updateFileName(e.target.files[0].name);
                }
            });
        }

        function updateFileName(fileName) {
            const fileNameDisplay = document.getElementById('fileName');
            if (fileNameDisplay) {
                fileNameDisplay.textContent = fileName;
                fileNameDisplay.classList.remove('hidden');
            }
        }

        function setupTooltips() {}
    </script>
@endpush
