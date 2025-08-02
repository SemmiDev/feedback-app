@extends('layouts.dashboard')

@section('title', 'All Feedbacks')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">All Feedbacks</h1>
            <p class="text-gray-600">Manage and review customer feedback</p>
        </div>
        <div class="text-sm text-gray-500">
            Total: {{ $feedbacks->total() }} feedbacks
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="px-4 py-5 sm:p-6">
        <form method="GET" action="{{ route('dashboard.feedbacks.index') }}" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="col-span-1">
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Search by preacher or mosque name, or comment..."
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <!-- Rating Filters -->
            <div>
                <label for="relevansi_rating" class="block text-sm font-medium text-gray-700">Relevansi Rating</label>
                <select
                    name="relevansi_rating"
                    id="relevansi_rating"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">All Ratings</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('relevansi_rating') == $i ? 'selected' : '' }}>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="kejelasan_rating" class="block text-sm font-medium text-gray-700">Kejelasan Rating</label>
                <select
                    name="kejelasan_rating"
                    id="kejelasan_rating"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">All Ratings</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('kejelasan_rating') == $i ? 'selected' : '' }}>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="pemahaman_jamaah_rating" class="block text-sm font-medium text-gray-700">Pemahaman Rating</label>
                <select
                    name="pemahaman_jamaah_rating"
                    id="pemahaman_jamaah_rating"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">All Ratings</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('pemahaman_jamaah_rating') == $i ? 'selected' : '' }}>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="kesesuaian_waktu_rating" class="block text-sm font-medium text-gray-700">Waktu Rating</label>
                <select
                    name="kesesuaian_waktu_rating"
                    id="kesesuaian_waktu_rating"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">All Ratings</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('kesesuaian_waktu_rating') == $i ? 'selected' : '' }}>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="interaksi_jamaah_rating" class="block text-sm font-medium text-gray-700">Interaksi Rating</label>
                <select
                    name="interaksi_jamaah_rating"
                    id="interaksi_jamaah_rating"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">All Ratings</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('interaksi_jamaah_rating') == $i ? 'selected' : '' }}>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                <select
                    name="sort"
                    id="sort"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date</option>
                    <option value="nama_penceramah" {{ request('sort') == 'nama_penceramah' ? 'selected' : '' }}>Preacher Name</option>
                    <option value="nama_masjid" {{ request('sort') == 'nama_masjid' ? 'selected' : '' }}>Mosque Name</option>
                    <option value="relevansi_rating" {{ request('sort') == 'relevansi_rating' ? 'selected' : '' }}>Relevansi Rating</option>
                    <option value="kejelasan_rating" {{ request('sort') == 'kejelasan_rating' ? 'selected' : '' }}>Kejelasan Rating</option>
                    <option value="pemahaman_jamaah_rating" {{ request('sort') == 'pemahaman_jamaah_rating' ? 'selected' : '' }}>Pemahaman Rating</option>
                    <option value="kesesuaian_waktu_rating" {{ request('sort') == 'kesesuaian_waktu_rating' ? 'selected' : '' }}>Waktu Rating</option>
                    <option value="interaksi_jamaah_rating" {{ request('sort') == 'interaksi_jamaah_rating' ? 'selected' : '' }}>Interaksi Rating</option>
                </select>
            </div>

            <!-- Direction -->
            <div>
                <label for="direction" class="block text-sm font-medium text-gray-700">Order</label>
                <select
                    name="direction"
                    id="direction"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-2 sm:space-x-2 sm:col-span-2 lg:col-span-1 w-full">
                <button
                    type="submit"
                    class="w-full sm:w-auto  justify-center bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-semibold py-2 px-4 sm:py-3 sm:px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-50 border-0 text-sm sm:text-base"
                    style="background-color: #10b981 !important; color: white !important;"
                >
                    Filter
                </button>
                <a
                    href="{{ route('dashboard.feedbacks.index') }}"
                    class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 sm:py-3 sm:px-6 border border-gray-300 text-sm sm:text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Feedbacks List -->
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($feedbacks->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($feedbacks as $feedback)
                <li>
                    <div class="px-4 py-4 sm:flex sm:items-start sm:space-x-4 hover:bg-gray-50">
                        <!-- Avatar -->
                        <div class="flex-shrink-0 sm:mt-1">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-700">{{ substr($feedback->nama_penceramah ?? 'Anonim', 0, 1) }}</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0 mt-3 sm:mt-0">
                            <div class="sm:flex sm:items-center sm:justify-between">
                                <div class="w-full sm:w-auto">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $feedback->nama_penceramah ?? 'Anonim' }}
                                    </p>
                                    <p class="text-sm text-gray-600 truncate">
                                        {{ $feedback->nama_masjid ?? 'Tidak disebutkan' }}
                                    </p>
                                    <div class="mt-1 flex flex-wrap gap-2 sm:gap-3">
                                        <span class="text-xs {{ $feedback->average_rating_color }}">Avg: {{ $feedback->average_stars }}</span>
                                        <span class="text-xs {{ $feedback->relevansi_rating_color }}">Relevansi: {{ $feedback->relevansi_stars }}</span>
                                        <span class="text-xs {{ $feedback->kejelasan_rating_color }}">Kejelasan: {{ $feedback->kejelasan_stars }}</span>
                                        <span class="text-xs {{ $feedback->pemahaman_jamaah_rating_color }}">Pemahaman: {{ $feedback->pemahaman_jamaah_stars }}</span>
                                        <span class="text-xs {{ $feedback->kesesuaian_waktu_rating_color }}">Waktu: {{ $feedback->kesesuaian_waktu_stars }}</span>
                                        <span class="text-xs {{ $feedback->interaksi_jamaah_rating_color }}">Interaksi: {{ $feedback->interaksi_jamaah_stars }}</span>
                                    </div>
                                    @if($feedback->saran)
                                        <p class="mt-2 text-sm text-gray-600 sm:line-clamp-2">
                                            {{ $feedback->saran }}
                                        </p>
                                    @else
                                        <p class="mt-2 text-sm text-gray-400 italic">
                                            No comment provided
                                        </p>
                                    @endif
                                    <p class="mt-1 text-xs text-gray-400">
                                        Submitted {{ $feedback->created_at_for_humans }}
                                    </p>
                                </div>
                                <div class="mt-2 sm:mt-0 sm:text-right">
                                    <div class="text-xs text-gray-500">
                                        {{ $feedback->formatted_date }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $feedback->formatted_time }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-3 sm:mt-0 sm:ml-4 flex items-center space-x-2 sm:flex-col sm:space-y-2 sm:space-x-0">
                            <a
                                href="{{ route('dashboard.feedbacks.show', $feedback) }}"
                                class="text-emerald-600 hover:text-emerald-500 text-sm font-medium ml-2 px-3 py-1 rounded transition-colors w-full text-center"
                                style="background-color: #d1fae5;"
                            >
                                View
                            </a>
                            <form
                                method="POST"
                                action="{{ route('dashboard.feedbacks.destroy', $feedback) }}"
                                class="inline w-full"
                                onsubmit="return confirm('Are you sure you want to delete this feedback?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="text-red-600 hover:text-white text-sm font-medium px-3 py-1 rounded transition-colors w-full text-center"
                                    style="background-color: #fee2e2;"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $feedbacks->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No feedbacks found</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if(request()->hasAny(['search', 'relevansi_rating', 'kejelasan_rating', 'pemahaman_jamaah_rating', 'kesesuaian_waktu_rating', 'interaksi_jamaah_rating']))
                    Try adjusting your filters or search terms.
                @else
                    Get started by sharing your feedback form with users.
                @endif
            </p>
        </div>
    @endif
</div>
@endsection
