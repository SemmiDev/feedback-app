@extends('layouts.app')

@section('title', 'Masuk Pengurus Masjid')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mb-6">
                <div class="flex items-center justify-center space-x-4 mb-4">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <img src="/logo-mui.png" alt="MUI Logo" class="object-contain w-12 h-12 drop-shadow-md">
                    </div>
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <img src="/logo-unri.png" alt="UNRI Logo" class="object-contain w-10 h-10 drop-shadow-md">
                    </div>
                </div>
                <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-emerald-700 drop-shadow-sm tracking-tight">
                    <span class="block">Sistem Evaluasi Cerdas</span>
                    <span class="block text-emerald-900 text-opacity-80 font-bold text-lg md:text-2xl mt-1">Untuk Optimalisasi Dakwah</span>
                </h2>
                <p class="mt-4 text-base text-gray-500 italic flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3 1.343 3 3 3 3-1.343 3-3zm0 0c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3zm0 8v-4"></path>
                    </svg>
                    Masuk ke <span class="font-semibold text-emerald-700">Panel Pengurus Masjid</span>
                </p>
            </div>
        </div>

        <form class="mt-8 space-y-6" action="/login-pengurus-masjid" method="POST">
            @csrf
            <div class="bg-white shadow-xl rounded-lg p-6">
                <div class="space-y-6">
                    <!-- Mosque Name Select2 Field -->
                    <div>
                        <label for="mosque_name" class="block text-sm mb-1 font-medium text-gray-700">
                            Nama Masjid
                        </label>
                        <select
                            id="mosque_name"
                            name="mosque_name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('mosque_name') border-red-500 @enderror"
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

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Kata Sandi
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan kata sandi Anda"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            class="w-full bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-50 border-0"
                            style="background-color: #10b981 !important; color: white !important;">
                            Masuk
                        </button>
                    </div>

                    <div class="pt-4 text-center">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 text-base font-semibold text-emerald-600 hover:text-emerald-500 transition-colors duration-200">
                            <span
                                class="underline decoration-emerald-400 decoration-2 underline-offset-4 hover:decoration-emerald-600">
                                Masuk sebagai Admin / Penceramah
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Back to Feedback -->
        <div class="text-center">
            <a href="{{ route('feedback.create') }}" class="text-sm text-emerald-600 hover:text-emerald-500">
                ← Kembali ke Formulir Feedback
            </a>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-results__option .mosque-address {
            font-size: 0.65rem;
            color: #6b7280;
            margin-top: 2px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                                    imapp_id: item.imapp_id_masjid,
                                    alamat: item.alamat || 'Alamat tidak tersedia'
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                templateResult: function(result) {
                    if (result.loading) return result.text;
                    var $container = $('<div></div>');
                    $container.append($('<div></div>').text(result.text));
                    $container.append($('<div class="mosque-address"></div>').text(result.alamat || 'Alamat tidak tersedia'));
                    return $container;
                },
                templateSelection: function(result) {
                    return result.text || result.id;
                },
                escapeMarkup: function(markup) {
                    return markup;
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                $('#imapp_id_masjid').val(data.imapp_id || '');
            }).on('select2:unselect', function() {
                $('#imapp_id_masjid').val('');
            });
        });
    </script>
@endpush
@endsection
