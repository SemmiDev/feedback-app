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
        <form method="GET" action="{{ route('dashboard.feedbacks.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-end sm:space-x-4">
            <!-- Search -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name or comment..."
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <!-- Rating Filter -->
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <select
                    name="rating"
                    id="rating"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">All Ratings</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
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
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
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
            <div class="flex space-x-2">
                <button
                    type="submit"
                    {{-- class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500" --}}
                    class="w-full inline-flex bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-50 border-0"
                    style="background-color: #10b981 !important; color: white !important;">
                    Filter
                </button>
                <a
                    href="{{ route('dashboard.feedbacks.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
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
                    <div class="px-4 py-4 flex items-center justify-between hover:bg-gray-50">
                        <div class="flex items-center space-x-4 flex-1">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">{{ substr($feedback->name, 0, 1) }}</span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $feedback->name }}
                                    </p>
                                    <div class="flex items-center space-x-2">
                                        <span class="{{ $feedback->rating_color }} text-sm">{{ $feedback->stars }}</span>
                                        <div class="text-right">
                                            <div class="text-xs text-gray-500">
                                                {{ $feedback->formatted_date }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $feedback->formatted_time }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($feedback->comment)
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                        {{ $feedback->comment }}
                                    </p>
                                @else
                                    <p class="mt-1 text-sm text-gray-400 italic">
                                        No comment provided
                                    </p>
                                @endif
                                <p class="mt-1 text-xs text-gray-400">
                                    Submitted {{ $feedback->created_at_for_humans }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2 ml-4">
                            <a
                                href="{{ route('dashboard.feedbacks.show', $feedback) }}"
                                class="text-emerald-600 hover:text-emerald-500 text-sm font-medium px-3 py-1 rounded transition-colors"
                                style="background-color: #d1fae5;"
                            >
                                View
                            </a>
                            <form
                                method="POST"
                                action="{{ route('dashboard.feedbacks.destroy', $feedback) }}"
                                class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this feedback?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="text-red-600 hover:text-white text-sm font-medium px-3 py-1 rounded transition-colors"
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
                @if(request()->hasAny(['search', 'rating']))
                    Try adjusting your filters or search terms.
                @else
                    Get started by sharing your feedback form with users.
                @endif
            </p>
        </div>
    @endif
</div>
@endsection
