@extends('layouts.dashboard')

@section('title', 'Export Feedback')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ekspor Umpan Balik</h1>
                <p class="text-gray-600">Unduh data umpan balik sebagai file CSV dengan kolom dan rentang tanggal yang dipilih</p>
            </div>
            <a href="{{ route('dashboard.feedbacks.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-emerald-600 hover:text-emerald-500 hover:bg-gray-50 transition-colors">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Ekspor Data Umpan Balik</h3>
            <p class="mt-1 text-sm text-gray-600">Pilih rentang tanggal dan kolom yang ingin disertakan dalam ekspor CSV.</p>
        </div>

        <div class="border-t border-gray-200">
            <form action="{{ route('dashboard.feedbacks.export.csv') }}" method="POST" class="px-4 py-5 sm:p-6">
                @csrf

                <!-- Date Range -->
                <div class="bg-gray-50 px-4 py-5 sm:p-6 rounded-lg mb-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-4">Rentang Waktu</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai
                            </label>
                            <input type="date" id="start_date" name="start_date"
                                value="{{ old('start_date', now()->subDays(30)->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('start_date') border-red-500 @enderror">
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Sampai
                            </label>
                            <input type="date" id="end_date" name="end_date"
                                value="{{ old('end_date', now()->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('end_date') border-red-500 @enderror">
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Column Selection -->
                <div class="bg-gray-50 px-4 py-5 sm:p-6 rounded-lg mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Pilih Kolom</h4>
                        <div class="flex items-center">
                            <input type="checkbox" id="select_all_columns"
                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                            <label for="select_all_columns" class="ml-2 text-sm text-gray-600">Pilih Semua</label>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($columns as $key => $label)
                            <div class="flex items-center">
                                <input type="checkbox" id="columns_{{ $key }}" name="columns[]"
                                    value="{{ $key }}"
                                    class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded column-checkbox"
                                    {{ in_array($key, old('columns', [])) ? 'checked' : '' }}>
                                <label for="columns_{{ $key }}"
                                    class="ml-2 text-sm text-gray-600">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('columns')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center justify-center w-full md:w-auto bg-gradient-to-r from-emerald-500 via-emerald-600 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-60 border-0 group"
                        style="background: linear-gradient(90deg, #10b981 0%, #059669 100%); color: white !important; letter-spacing: 0.03em;">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-white group-hover:text-yellow-300 transition-colors duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span class="tracking-wide text-lg drop-shadow-sm">Unduh CSV</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select All Checkbox
                const selectAllCheckbox = document.getElementById('select_all_columns');
                const columnCheckboxes = document.querySelectorAll('.column-checkbox');

                selectAllCheckbox.addEventListener('change', function() {
                    columnCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });

                columnCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (!this.checked) {
                            selectAllCheckbox.checked = false;
                        } else if (Array.from(columnCheckboxes).every(cb => cb.checked)) {
                            selectAllCheckbox.checked = true;
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
