@extends('layouts.dashboard')

@section('title', 'Feedback Details')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Feedback Details</h1>
            <p class="text-gray-600">View detailed feedback information</p>
        </div>
        <a
            href="{{ route('dashboard.feedbacks.index') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-emerald-600 hover:text-emerald-500 hover:bg-gray-50 transition-colors"
        >
            ← Back to Feedbacks
        </a>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                <span class="text-xl font-medium text-gray-700">{{ substr($feedback->nama_penceramah ?? 'Anonim', 0, 1) }}</span>
            </div>
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $feedback->nama_penceramah ?? 'Anonim' }}
                </h3>
                <p class="text-sm text-gray-600">{{ $feedback->nama_masjid ?? 'Tidak disebutkan' }}</p>
                <div class="flex items-center space-x-2 mt-1">
                    <span class="{{ $feedback->average_rating_color }} text-lg">{{ $feedback->average_stars }}</span>
                    <span class="text-sm text-gray-500">
                        {{ number_format($feedback->average_rating, 1) }}/5 stars (Average)
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Submitted on
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $feedback->display_datetime }}
                    <span class="text-gray-500">
                        ({{ $feedback->created_at_for_humans }})
                    </span>
                </dd>
            </div>

            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Ratings
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span>Relevansi Materi:</span>
                            <div class="flex items-center space-x-2">
                                <span class="{{ $feedback->relevansi_rating_color }} text-lg">{{ $feedback->relevansi_stars }}</span>
                                <span class="text-gray-600">{{ $feedback->relevansi_rating }}/5</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Kejelasan Penyampaian:</span>
                            <div class="flex items-center space-x-2">
                                <span class="{{ $feedback->kejelasan_rating_color }} text-lg">{{ $feedback->kejelasan_stars }}</span>
                                <span class="text-gray-600">{{ $feedback->kejelasan_rating }}/5</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Pemahaman Jamaah:</span>
                            <div class="flex items-center space-x-2">
                                <span class="{{ $feedback->pemahaman_jamaah_rating_color }} text-lg">{{ $feedback->pemahaman_jamaah_stars }}</span>
                                <span class="text-gray-600">{{ $feedback->pemahaman_jamaah_rating }}/5</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Kesesuaian Waktu:</span>
                            <div class="flex items-center space-x-2">
                                <span class="{{ $feedback->kesesuaian_waktu_rating_color }} text-lg">{{ $feedback->kesesuaian_waktu_stars }}</span>
                                <span class="text-gray-600">{{ $feedback->kesesuaian_waktu_rating }}/5</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Interaksi Jamaah:</span>
                            <div class="flex items-center space-x-2">
                                <span class="{{ $feedback->interaksi_jamaah_rating_color }} text-lg">{{ $feedback->interaksi_jamaah_stars }}</span>
                                <span class="text-gray-600">{{ $feedback->interaksi_jamaah_rating }}/5</span>
                            </div>
                        </div>
                    </div>
                </dd>
            </div>

            @if($feedback->saran)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Saran/Kesan
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <p class="whitespace-pre-wrap">{{ $feedback->saran }}</p>
                        </div>
                    </dd>
                </div>
            @else
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Saran/Kesan
                    </dt>
                    <dd class="mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2 italic">
                        No comment provided
                    </dd>
                </div>
            @endif

            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Timezone Information
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="space-y-1">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Local Time (WIB):</span>
                            <span>{{ $feedback->formatted_created_at }}</span>
                        </div>
                        {{-- <div class="flex justify-between">
                            <span class="text-gray-600">UTC Time:</span>
                            <span>{{ $feedback->created_at->format('d M Y, H:i') }} UTC</span>
                        </div> --}}
                    </div>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Actions -->
    @if(auth()->user()->isAdmin())
    <div class="bg-gray-50 px-4 py-4 sm:px-6">
        <div class="flex justify-end space-x-3">
            <form
                method="POST"
                action="{{ route('dashboard.feedbacks.destroy', $feedback) }}"
                onsubmit="return confirm('Are you sure you want to delete this feedback? This action cannot be undone.')"
            >
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Feedback
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
