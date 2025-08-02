@extends('layouts.app')

@section('title', 'Sistem Evaluasi Cerdas MUI Riau')

@section('content')
<div class="min-h-screen bg-gray-100 py-4 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header with Green Background -->
        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white p-4 sm:p-6 rounded-t-lg shadow-lg"
            style="background: linear-gradient(135deg, #10b981, #059669, #047857);">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-white/10 flex items-center justify-center overflow-hidden backdrop-blur-sm">
                        <img src="/logo-mui.png" alt="MUI Logo" class="object-contain w-12 h-12 sm:w-16 sm:h-16">
                    </div>
                    <div class="flex flex-col gap-1">
                        <h1 class="text-base sm:text-xl font-bold leading-tight">Sistem Evaluasi Cerdas Untuk
                            Optimalisasi Dakwah</h1>
                        <h1 class="text-base sm:text-xl font-bold leading-tight">Di Majelis Ulama Indonesia Provinsi
                            Riau</h1>
                    </div>
                </div>
                <div
                    class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-white/10 flex items-center justify-center overflow-hidden backdrop-blur-sm">
                    <img src="/logo-unri.png" alt="UNRI Logo" class="object-contain w-10 h-10 sm:w-14 sm:h-14">
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white shadow-lg rounded-b-lg p-4 sm:p-6">
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
                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-6" id="feedback-form">
                    @csrf

                    <!-- Informasi Jamaah -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="preacher_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Penceramah (Jika Ada)
                            </label>
                            <select
                                id="preacher_name"
                                name="preacher_name"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-sm sm:text-base @error('preacher_name') border-red-500 @enderror"
                            >
                                <option value="">Pilih atau ketik nama penceramah...</option>
                                @if (old('preacher_name'))
                                    <option value="{{ old('preacher_name') }}" selected>{{ old('preacher_name') }}</option>
                                @endif
                            </select>
                            <input type="hidden" id="imapp_id_penceramah" name="imapp_id_penceramah" value="{{ old('imapp_id_penceramah') }}">
                            @error('preacher_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mosque_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Masjid
                            </label>
                            <select
                                id="mosque_name"
                                name="mosque_name"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-sm sm:text-base @error('mosque_name') border-red-500 @enderror"
                            >
                                <option value="">Pilih atau ketik nama masjid...</option>
                                @if (old('mosque_name'))
                                    <option value="{{ old('mosque_name') }}" selected>{{ old('mosque_name') }}</option>
                                @endif
                            </select>
                            <input type="hidden" id="imapp_id_masjid" name="imapp_id_masjid" value="{{ old('imapp_id_masjid') }}">
                            @error('mosque_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Rating Sections with Accordion -->
                    <div class="space-y-4" id="accordion-collapse" data-accordion="collapse">
                        <!-- 1. Relevansi Materi Dakwah -->
                        <div class="border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-white to-gray-50">
                            <h3 id="accordion-heading-1">
                                <button type="button" class="flex items-center justify-between w-full p-4 sm:p-6 font-medium text-gray-800 text-left" data-accordion-target="#accordion-body-1" aria-expanded="true" aria-controls="accordion-body-1">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-emerald-600 font-bold text-sm">1</span>
                                        </div>
                                        <span class="text-base sm:text-lg font-semibold">Relevansi Materi Dakwah</span>
                                    </div>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </h3>
                            <div id="accordion-body-1" class="hidden" aria-labelledby="accordion-heading-1">
                                <div class="p-4 sm:p-6 pt-0">
                                    <p class="text-sm sm:text-base text-gray-600 mb-4 ml-11">Sejauh mana materi sesuai dengan kebutuhan?</p>
                                    <div class="flex flex-col items-center ml-11">
                                        <div class="flex items-center justify-center space-x-1 sm:space-x-2 py-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group flex flex-col items-center">
                                                    <input type="radio" name="relevance_rating" value="{{ $i }}"
                                                        class="sr-only rating-input"
                                                        {{ old('relevance_rating') == $i ? 'checked' : '' }}>
                                                    <div
                                                        class="w-8 h-8 sm:w-10 sm:h-10 text-2xl sm:text-3xl transition-all duration-300 star-icon flex items-center justify-center transform hover:scale-110 group-hover:drop-shadow-lg">
                                                        ⭐
                                                    </div>
                                                    <span class="text-xs text-gray-500 mt-1">{{ $i }}</span>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between w-full mt-2">
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Tidak Relevan</span>
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Sangat Relevan</span>
                                        </div>
                                    </div>
                                    @error('relevance_rating')
                                        <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 2. Kejelasan & Kualitas Penyampaian -->
                        <div class="border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-white to-gray-50">
                            <h3 id="accordion-heading-2">
                                <button type="button" class="flex items-center justify-between w-full p-4 sm:p-6 font-medium text-gray-800 text-left" data-accordion-target="#accordion-body-2" aria-expanded="false" aria-controls="accordion-body-2">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-emerald-600 font-bold text-sm">2</span>
                                        </div>
                                        <span class="text-base sm:text-lg font-semibold">Kejelasan & Kualitas Penyampaian</span>
                                    </div>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </h3>
                            <div id="accordion-body-2" class="hidden" aria-labelledby="accordion-heading-2">
                                <div class="p-4 sm:p-6 pt-0">
                                    <p class="text-sm sm:text-base text-gray-600 mb-4 ml-11">Apakah ceramah jelas, mudah dipahami, menarik?</p>
                                    <div class="flex flex-col items-center ml-11">
                                        <div class="flex items-center justify-center space-x-1 sm:space-x-2 py-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group flex flex-col items-center">
                                                    <input type="radio" name="clarity_rating" value="{{ $i }}"
                                                        class="sr-only rating-input"
                                                        {{ old('clarity_rating') == $i ? 'checked' : '' }}>
                                                    <div
                                                        class="w-8 h-8 sm:w-10 sm:h-10 text-2xl sm:text-3xl transition-all duration-300 star-icon flex items-center justify-center transform hover:scale-110 group-hover:drop-shadow-lg">
                                                        ⭐
                                                    </div>
                                                    <span class="text-xs text-gray-500 mt-1">{{ $i }}</span>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between w-full mt-2">
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Tidak Jelas</span>
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Sangat Jelas</span>
                                        </div>
                                    </div>
                                    @error('clarity_rating')
                                        <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 3. Pemahaman Jamaah terhadap Isi Ceramah -->
                        <div class="border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-white to-gray-50">
                            <h3 id="accordion-heading-3">
                                <button type="button" class="flex items-center justify-between w-full p-4 sm:p-6 font-medium text-gray-800 text-left" data-accordion-target="#accordion-body-3" aria-expanded="false" aria-controls="accordion-body-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-emerald-600 font-bold text-sm">3</span>
                                        </div>
                                        <span class="text-base sm:text-lg font-semibold">Pemahaman Jamaah terhadap Isi Ceramah</span>
                                    </div>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </h3>
                            <div id="accordion-body-3" class="hidden" aria-labelledby="accordion-heading-3">
                                <div class="p-4 sm:p-6 pt-0">
                                    <p class="text-sm sm:text-base text-gray-600 mb-4 ml-11">Seberapa paham Jamaah dengan isi ceramah?</p>
                                    <div class="flex flex-col items-center ml-11">
                                        <div class="flex items-center justify-center space-x-1 sm:space-x-2 py-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group flex flex-col items-center">
                                                    <input type="radio" name="understanding_rating" value="{{ $i }}"
                                                        class="sr-only rating-input"
                                                        {{ old('understanding_rating') == $i ? 'checked' : '' }}>
                                                    <div
                                                        class="w-8 h-8 sm:w-10 sm:h-10 text-2xl sm:text-3xl transition-all duration-300 star-icon flex items-center justify-center transform hover:scale-110 group-hover:drop-shadow-lg">
                                                        ⭐
                                                    </div>
                                                    <span class="text-xs text-gray-500 mt-1">{{ $i }}</span>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between w-full mt-2">
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Tidak Paham</span>
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Sangat Paham</span>
                                        </div>
                                    </div>
                                    @error('understanding_rating')
                                        <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 4. Kesesuaian Waktu & Durasi Ceramah -->
                        <div class="border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-white to-gray-50">
                            <h3 id="accordion-heading-4">
                                <button type="button" class="flex items-center justify-between w-full p-4 sm:p-6 font-medium text-gray-800 text-left" data-accordion-target="#accordion-body-4" aria-expanded="false" aria-controls="accordion-body-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-emerald-600 font-bold text-sm">4</span>
                                        </div>
                                        <span class="text-base sm:text-lg font-semibold">Kesesuaian Waktu & Durasi Ceramah</span>
                                    </div>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </h3>
                            <div id="accordion-body-4" class="hidden" aria-labelledby="accordion-heading-4">
                                <div class="p-4 sm:p-6 pt-0">
                                    <p class="text-sm sm:text-base text-gray-600 mb-4 ml-11">Apakah waktu & durasi ceramah sudah sesuai?</p>
                                    <div class="flex flex-col items-center ml-11">
                                        <div class="flex items-center justify-center space-x-1 sm:space-x-2 py-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group flex flex-col items-center">
                                                    <input type="radio" name="timing_rating" value="{{ $i }}"
                                                        class="sr-only rating-input"
                                                        {{ old('timing_rating') == $i ? 'checked' : '' }}>
                                                    <div
                                                        class="w-8 h-8 sm:w-10 sm:h-10 text-2xl sm:text-3xl transition-all duration-300 star-icon flex items-center justify-center transform hover:scale-110 group-hover:drop-shadow-lg">
                                                        ⭐
                                                    </div>
                                                    <span class="text-xs text-gray-500 mt-1">{{ $i }}</span>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between w-full mt-2">
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Tidak Sesuai</span>
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Sangat Sesuai</span>
                                        </div>
                                    </div>
                                    @error('timing_rating')
                                        <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 5. Interaksi & Keterlibatan Jamaah -->
                        <div class="border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-white to-gray-50">
                            <h3 id="accordion-heading-5">
                                <button type="button" class="flex items-center justify-between w-full p-4 sm:p-6 font-medium text-gray-800 text-left" data-accordion-target="#accordion-body-5" aria-expanded="false" aria-controls="accordion-body-5">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-emerald-600 font-bold text-sm">5</span>
                                        </div>
                                        <span class="text-base sm:text-lg font-semibold">Interaksi & Keterlibatan Jamaah</span>
                                    </div>
                                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </h3>
                            <div id="accordion-body-5" class="hidden" aria-labelledby="accordion-heading-5">
                                <div class="p-4 sm:p-6 pt-0">
                                    <p class="text-sm sm:text-base text-gray-600 mb-4 ml-11">Apakah ada sesi tanya jawab, interaksi?</p>
                                    <div class="flex flex-col items-center ml-11">
                                        <div class="flex items-center justify-center space-x-1 sm:space-x-2 py-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label class="cursor-pointer group flex flex-col items-center">
                                                    <input type="radio" name="interaction_rating" value="{{ $i }}"
                                                        class="sr-only rating-input"
                                                        {{ old('interaction_rating') == $i ? 'checked' : '' }}>
                                                    <div
                                                        class="w-8 h-8 sm:w-10 sm:h-10 text-2xl sm:text-3xl transition-all duration-300 star-icon flex items-center justify-center transform hover:scale-110 group-hover:drop-shadow-lg">
                                                        ⭐
                                                    </div>
                                                    <span class="text-xs text-gray-500 mt-1">{{ $i }}</span>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between w-full mt-2">
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Tidak Berinteraksi</span>
                                            <span class="text-xs sm:text-sm text-gray-500 font-medium">Sangat Berinteraksi</span>
                                        </div>
                                    </div>
                                    @error('interaction_rating')
                                        <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Saran/Kesan -->
                    <div>
                        <label for="suggestions" class="block text-sm font-medium text-gray-700 mb-2">
                            Saran/Kesan
                        </label>
                        <textarea id="suggestions" name="suggestions" rows="4"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none text-sm sm:text-base @error('suggestions') border-red-500 @enderror"
                            placeholder="Masukkan saran atau kesan Anda...">{{ old('suggestions') }}</textarea>
                        @error('suggestions')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-50 border-0 text-sm sm:text-base"
                            style="background-color: #10b981 !important; color: white !important;">
                            <span class="flex items-center justify-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                KIRIM NILAI / SUBMIT
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
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://unpkg.com/@themesberg/flowbite@1.3.0/dist/flowbite.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://unpkg.com/@themesberg/flowbite@1.3.0/dist/flowbite.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Select2 for Nama Penceramah
                $('#preacher_name').select2({
                    placeholder: 'Pilih atau ketik nama penceramah...',
                    allowClear: true,
                    tags: true,
                    ajax: {
                        url: '{{ route('autocomplete.penceramah') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term || ''
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results.map(function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text,
                                        imapp_id: item.imapp_id_penceramah
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1,
                    templateResult: function(result) {
                        if (result.loading) return result.text;
                        return $('<div>' + result.text + '</div>');
                    },
                    templateSelection: function(result) {
                        return result.text || result.id;
                    }
                }).on('select2:select', function(e) {
                    var data = e.params.data;
                    $('#imapp_id_penceramah').val(data.imapp_id || '');
                }).on('select2:unselect', function() {
                    $('#imapp_id_penceramah').val('');
                });

                // Initialize Select2 for Nama Masjid
                $('#mosque_name').select2({
                    placeholder: 'Pilih atau ketik nama masjid...',
                    allowClear: true,
                    tags: true,
                    ajax: {
                        url: '{{ route('autocomplete.masjid') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term || ''
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results.map(function(item) {
                                    return {
                                        id: item.text,
                                        text: item.text,
                                        imapp_id: item.imapp_id_masjid
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1,
                    templateResult: function(result) {
                        if (result.loading) return result.text;
                        return $('<div>' + result.text + '</div>');
                    },
                    templateSelection: function(result) {
                        return result.text || result.id;
                    }
                }).on('select2:select', function(e) {
                    var data = e.params.data;
                    $('#imapp_id_masjid').val(data.imapp_id || '');
                }).on('select2:unselect', function() {
                    $('#imapp_id_masjid').val('');
                });

                // Prevent double submission
                $('#feedback-form').on('submit', function(e) {
                    var $form = $(this);
                    if ($form.data('submitted')) {
                        e.preventDefault();
                        return;
                    }
                    $form.data('submitted', true);
                    setTimeout(function() {
                        $form.data('submitted', false);
                    }, 1000);
                });

                // Star rating JavaScript
                const ratingGroups = [
                    'relevance_rating',
                    'clarity_rating',
                    'understanding_rating',
                    'timing_rating',
                    'interaction_rating'
                ];

                ratingGroups.forEach(groupName => {
                    const ratingInputs = document.querySelectorAll(`input[name="${groupName}"]`);
                    const starIcons = document.querySelectorAll(`input[name="${groupName}"] + div`);
                    const container = document.querySelector(`input[name="${groupName}"]`).closest(
                        '.flex.items-center.justify-center');

                    resetStars(groupName);

                    const checkedInput = document.querySelector(`input[name="${groupName}"]:checked`);
                    if (checkedInput) {
                        updateStars(groupName, parseInt(checkedInput.value));
                    }

                    ratingInputs.forEach((input, index) => {
                        const starIcon = input.nextElementSibling;

                        input.addEventListener('change', function() {
                            if (this.checked) {
                                updateStars(groupName, parseInt(this.value));
                            }
                        });

                        starIcon.addEventListener('click', function() {
                            const rating = index + 1;
                            ratingInputs[index].checked = true;
                            updateStars(groupName, rating);
                        });

                        starIcon.addEventListener('mouseenter', function() {
                            const rating = index + 1;
                            highlightStars(groupName, rating);
                        });
                    });

                    if (container) {
                        container.addEventListener('mouseleave', function() {
                            const checkedInput = document.querySelector(
                                `input[name="${groupName}"]:checked`);
                            if (checkedInput) {
                                updateStars(groupName, parseInt(checkedInput.value));
                            } else {
                                resetStars(groupName);
                            }
                        });
                    }
                });

                function updateStars(groupName, rating) {
                    const starIcons = document.querySelectorAll(`input[name="${groupName}"] + div`);
                    starIcons.forEach((star, index) => {
                        if (index < rating) {
                            star.style.filter = 'grayscale(0%) brightness(1.2)';
                            star.style.transform = 'scale(1.1)';
                        } else {
                            star.style.filter = 'grayscale(100%) brightness(0.7)';
                            star.style.transform = 'scale(1)';
                        }
                    });
                }

                function highlightStars(groupName, rating) {
                    const starIcons = document.querySelectorAll(`input[name="${groupName}"] + div`);
                    starIcons.forEach((star, index) => {
                        if (index < rating) {
                            star.style.filter = 'grayscale(0%) brightness(1.2)';
                            star.style.transform = 'scale(1.1)';
                        } else {
                            star.style.filter = 'grayscale(100%) brightness(0.7)';
                            star.style.transform = 'scale(1)';
                        }
                    });
                }

                function resetStars(groupName) {
                    const starIcons = document.querySelectorAll(`input[name="${groupName}"] + div`);
                    starIcons.forEach(star => {
                        star.style.filter = 'grayscale(100%) brightness(0.7)';
                        star.style.transform = 'scale(1)';
                    });
                }
            });
        </script>
    @endpush
</div>
@endsection
