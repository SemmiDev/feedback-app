@extends('layouts.dashboard')

@section('title', 'Topic Modeling')

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.1.0/wordcloud2.min.js"></script>
@endpush

@section('content')
    <div class="mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Topic Modeling Dashboard</h1>
                <p class="text-gray-600">Analisis topik, kata kunci, dan sentimen dari data feedback.</p>
                <p class="text-sm text-gray-500 mt-1">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Terakhir diperbarui: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                </p>
            </div>
            <div class="flex space-x-3">
                <button onclick="openUploadModal()"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload CSV
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $stats = [
                ['label' => 'Total Topik', 'value' => number_format($totalTopics), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-5v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2z"></path>', 'color' => 'bg-purple-500'],
                ['label' => 'Total Dokumen', 'value' => number_format($totalDocuments), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>', 'color' => 'bg-blue-500'],
                // ['label' => 'Rata-rata Sentimen', 'value' => number_format($averageTopicSentiment, 3), 'icon' => ($averageTopicSentiment >= 0.2 ? '😊' : ($averageTopicSentiment <= -0.2 ? '😞' : '😐')), 'color' => ($averageTopicSentiment >= 0.2 ? 'bg-green-500' : ($averageTopicSentiment <= -0.2 ? 'bg-red-500' : 'bg-yellow-500'))],
                // ['label' => 'Topik Terpopuler', 'value' => $mostDiscussedTopic ? 'Topic ' . $mostDiscussedTopic->topic_id : '-', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>', 'color' => 'bg-orange-500'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white overflow-hidden shadow rounded-lg transform hover:-translate-y-1 transition-transform duration-300">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 {{ $stat['color'] }} rounded-md flex items-center justify-center text-white text-xl font-bold">
                            @if(strpos($stat['icon'], '<path') !== false)
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $stat['icon'] !!}</svg>
                            @else
                                {{ $stat['icon'] }}
                            @endif
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ $stat['label'] }}</dt>
                            <dd class="text-xl font-semibold text-gray-900">{{ $stat['value'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg lg:col-span-3">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Word Cloud Kata Kunci Teratas</h3>
                <div id="wordCloudContainer" class="w-full h-80 min-h-full flex items-center justify-center bg-gray-50 rounded-lg">
                    {{-- Word cloud will be generated here by wordcloud2.js --}}
                    <p id="wordCloudPlaceholder" class="text-gray-500">Generating word cloud...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Topik Detail</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi lengkap tentang setiap topik yang teridentifikasi. Klik header untuk mengurutkan.</p>
        </div>
        <div class="border-t border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topik</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kata Kunci Utama</th>
                            <th scope="col" class="sortable-header px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="doc_count">Dokumen <span class="sort-icon"></span></th>
                            <th scope="col" class="sortable-header px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="share">Share <span class="sort-icon"></span></th>
                            <th scope="col" class="sortable-header px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="avg_topic_score">Score <span class="sort-icon"></span></th>
                        </tr>
                    </thead>
                    <tbody id="topicsTableBody" class="bg-white divide-y divide-gray-200">
                        {{-- Rows will be dynamically populated by JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Upload CSV Topic Modeling</h3>
                    <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('dashboard.topics.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">File CSV</label>
                        <input type="file" id="csv_file" name="csv_file" accept=".csv,.txt" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" required>
                        <p class="mt-2 text-xs text-gray-500">
                            Kolom yang dibutuhkan: topic_id, topic_keywords, doc_count, share, avg_topic_score, avg_sentiment, pos_rate, neg_rate, neu_rate
                        </p>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeUploadModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition duration-150">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition duration-150">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // --- DATA FROM LARAVEL ---
        const topicsData = @json($topicsByShare);
        const topicShareData = @json($topicShareData);
        const topicSentimentDistribution = @json($topicSentimentDistribution);
        const topKeywords = @json($topKeywords);

        // --- INITIALIZE ON PAGE LOAD ---
        document.addEventListener('DOMContentLoaded', function() {
            generateWordCloud();
            renderTable(topicsData); // Initial table render
        });


        // --- WORD CLOUD GENERATION ---
        function generateWordCloud() {
            const container = document.getElementById('wordCloudContainer');
            const placeholder = document.getElementById('wordCloudPlaceholder');
            const keywordList = Object.entries(topKeywords);

            if (keywordList.length === 0) {
                placeholder.innerText = 'Tidak ada data kata kunci untuk membuat word cloud.';
                return;
            }

            placeholder.style.display = 'none';

            // Normalize weights for better visualization
            const maxWeight = Math.max(...keywordList.map(k => k[1]));
            const wordCloudData = keywordList.map(([text, weight]) => [text, (weight / maxWeight) * 50 + 5]); // Scale weights

            WordCloud(container, {
                list: wordCloudData,
                gridSize: Math.round(16 * container.clientWidth / 1024),
                weightFactor: 1.2,
                fontFamily: 'sans-serif',
                color: (word, weight) => {
                    const colors = ['#8B5CF6', '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#6366F1'];
                    return colors[Math.floor(Math.random() * colors.length)];
                },
                backgroundColor: '#F9FAFB',
                rotationSteps: 2,
                rotateRatio: 0.3,
            });
        }

        // --- INTERACTIVE TABLE SORTING ---
        let currentSort = { key: 'share', direction: 'desc' };

        document.querySelectorAll('.sortable-header').forEach(header => {
            header.addEventListener('click', () => {
                const sortKey = header.dataset.sort;
                const direction = (currentSort.key === sortKey && currentSort.direction === 'desc') ? 'asc' : 'desc';

                currentSort = { key: sortKey, direction };

                sortAndRenderTable();
                updateSortIcons();
            });
        });

        function sortAndRenderTable() {
            const sortedData = [...topicsData].sort((a, b) => {
                let valA = a[currentSort.key];
                let valB = b[currentSort.key];

                if (currentSort.direction === 'asc') {
                    return valA > valB ? 1 : -1;
                } else {
                    return valA < valB ? 1 : -1;
                }
            });
            renderTable(sortedData);
        }

        function renderTable(data) {
            const tableBody = document.getElementById('topicsTableBody');
            tableBody.innerHTML = '';
            data.forEach(topic => {
                const keywords = topic.topic_keywords.split(', ');
                const primaryKeywords = keywords.slice(0, 3);
                const otherKeywordsCount = keywords.length - 3;

                const row = `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-purple-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-purple-800">${topic.topic_id}</span>
                                </div>
                                <div class="ml-4"><div class="text-sm font-medium text-gray-900">Topic ${topic.topic_id}</div></div>
                            </div>
                        </td>
                        <td class="px-6 py-4" style="min-width: 200px;">
                            <div class="flex flex-wrap gap-1.5">
                                ${primaryKeywords.map(kw => `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">${kw.trim()}</span>`).join('')}
                                ${otherKeywordsCount > 0 ? `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">+${otherKeywordsCount}</span>` : ''}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-mono">${Number(topic.doc_count).toLocaleString('id-ID')}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-indigo-500 h-2 rounded-full" style="width: ${topic.share * 100}%"></div>
                                </div>
                                <span class="text-sm text-gray-800 font-mono">${(topic.share * 100).toFixed(1)}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-mono">${Number(topic.avg_topic_score).toFixed(3)}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        function updateSortIcons() {
            document.querySelectorAll('.sortable-header').forEach(header => {
                const icon = header.querySelector('.sort-icon');
                if (header.dataset.sort === currentSort.key) {
                    icon.innerHTML = currentSort.direction === 'desc' ? '▼' : '▲';
                } else {
                    icon.innerHTML = ' ';
                }
            });
        }

        // --- MODAL CONTROLS ---
        function openUploadModal() { document.getElementById('uploadModal').classList.remove('hidden'); }
        function closeUploadModal() { document.getElementById('uploadModal').classList.add('hidden'); }
    </script>
@endsection
