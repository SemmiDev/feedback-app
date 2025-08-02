@extends('layouts.app')

@section('title', 'Sistem Evaluasi Cerdas MUI Riau')

@section('content')
    <div class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header with Green Background -->
            <div class="bg-emerald-500 text-white p-6 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <!-- MUI Logo Placeholder -->
                        <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                            <img src="/logo-mui.png" alt="MUI Logo" class="object-contain w-12 h-12">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Sistem Evaluasi Cerdas MUI Riau</h1>
                            <p class="text-emerald-100 text-sm">Penelitian Tahun 2025</p>
                        </div>
                    </div>
                    <!-- Second Logo Placeholder -->
                    <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                        <img src="/logo-unri.png" alt="UNRI Logo" class="object-contain w-10 h-10">
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white shadow-lg rounded-b-lg p-6">
                <!-- Form Title -->
                <div class="mb-6">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-800">Formulir Feedback Jamaah</h2>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-emerald-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($publicFeedbackEnabled)
                    <form action="{{ route('feedback.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nama Jamaah -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Jamaah
                            </label>
                            <input id="name" name="name" type="text" required value="{{ old('name') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Komentar Ceramah -->
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                                Komentar Ceramah
                            </label>
                            <textarea id="comment" name="comment" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none @error('comment') border-red-500 @enderror"
                                placeholder="Masukkan komentar...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rating Ceramah -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Rating Ceramah
                            </label>
                            <div class="flex items-center justify-center space-x-2 py-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}"
                                            class="sr-only rating-input" {{ old('rating') == $i ? 'checked' : '' }}
                                            required>
                                        <svg class="w-10 h-10 text-gray-300 hover:text-yellow-400 transition-colors duration-200 star-icon"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <p class="text-center text-sm text-gray-500 mt-2">Klik bintang untuk memberikan rating</p>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button - FIXED -->
                        <div>
                            <button type="submit"
                                class="w-full bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-50 border-0"
                                style="background-color: #10b981 !important; color: white !important;">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Kirim Feedback
                                </span>
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Formulir Feedback Tidak Tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Admin telah menonaktifkan formulir feedback publik untuk sementara. Silakan coba lagi nanti.
                        </p>
                    </div>
                @endif
                <!-- Admin Login Link -->
                {{-- <div class="text-center mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('login') }}" class="text-sm text-emerald-600 hover:text-emerald-500 font-medium">
                        Login Admin
                    </a>
                </div> --}}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ratingInputs = document.querySelectorAll('.rating-input');
                const starIcons = document.querySelectorAll('.star-icon');

                // Set initial state based on old input
                const checkedInput = document.querySelector('.rating-input:checked');
                if (checkedInput) {
                    updateStars(parseInt(checkedInput.value));
                }

                ratingInputs.forEach((input, index) => {
                    input.addEventListener('change', function() {
                        if (this.checked) {
                            updateStars(parseInt(this.value));
                        }
                    });
                });

                starIcons.forEach((star, index) => {
                    star.addEventListener('click', function() {
                        const rating = index + 1;
                        ratingInputs[index].checked = true;
                        updateStars(rating);
                    });

                    star.addEventListener('mouseenter', function() {
                        const rating = index + 1;
                        highlightStars(rating);
                    });
                });

                document.querySelector('.flex.items-center.justify-center.space-x-2').addEventListener('mouseleave',
                    function() {
                        const checkedInput = document.querySelector('.rating-input:checked');
                        if (checkedInput) {
                            updateStars(parseInt(checkedInput.value));
                        } else {
                            resetStars();
                        }
                    });

                function updateStars(rating) {
                    starIcons.forEach((star, index) => {
                        if (index < rating) {
                            star.classList.remove('text-gray-300');
                            star.classList.add('text-yellow-400');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                }

                function highlightStars(rating) {
                    starIcons.forEach((star, index) => {
                        if (index < rating) {
                            star.classList.remove('text-gray-300');
                            star.classList.add('text-yellow-400');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                }

                function resetStars() {
                    starIcons.forEach(star => {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    });
                }
            });
        </script>
    @endpush
@endsection
