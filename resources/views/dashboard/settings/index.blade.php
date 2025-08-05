@extends('layouts.dashboard')

@section('title', 'Pengaturan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Pengaturan Aplikasi</h1>
    <p class="text-gray-600">Kelola konfigurasi aplikasi dan preferensi pengguna.</p>
</div>

<!-- Pengaturan Profil -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="px-4 py-5 sm:p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengaturan Profil</h2>
        <p class="text-gray-600 mb-6">Perbarui informasi profil dan kata sandi akun Anda.</p>

        @if(session('success_profile'))
            <div class="flex items-center p-4 mb-4 text-sm text-emerald-800 border border-emerald-300 rounded-lg bg-emerald-50 animate-slide-in" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div>{{ session('success_profile') }}</div>
            </div>
        @endif

        <form action="{{ route('dashboard.settings.updateProfile') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Pengguna -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    value="{{ old('username', auth()->user()->username) }}"
                    required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('username') border-red-500 @enderror"
                >
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6 border-gray-200">

            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Kata Sandi</h3>

            <!-- Kata Sandi Saat Ini -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
                <input
                    type="password"
                    name="current_password"
                    id="current_password"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('current_password') border-red-500 @enderror"
                >
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kata Sandi Baru -->
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                <input
                    type="password"
                    name="new_password"
                    id="new_password"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('new_password') border-red-500 @enderror"
                >
                @error('new_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Kata Sandi Baru -->
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
                <input
                    type="password"
                    name="new_password_confirmation"
                    id="new_password_confirmation"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <div class="mt-6 flex justify-start">
                <button
                    type="submit"
                    class="bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-50 border-0"
                    style="background-color: #10b981 !important; color: white !important;">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Pengaturan Aplikasi -->
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengaturan Aplikasi</h2>
        <p class="text-gray-600 mb-6">Atur pengaturan umum aplikasi.</p>

        @if(session('success_application'))
            <div class="flex items-center p-4 mb-4 text-sm text-emerald-800 border border-emerald-300 rounded-lg bg-emerald-50 animate-slide-in" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div>{{ session('success_application') }}</div>
            </div>
        @endif

        <form action="{{ route('dashboard.settings.updateApplication') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Nama Aplikasi -->
            {{-- <div>
                <label for="app_name" class="block text-sm font-medium text-gray-700">Nama Aplikasi</label>
                <input
                    type="text"
                    name="app_name"
                    id="app_name"
                    value="{{ old('app_name', $appName) }}"
                    required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('app_name') border-red-500 @enderror"
                >
                @error('app_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}

            <!-- Toggle Formulir Umpan Balik Publik -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="public_feedback_enabled"
                    id="public_feedback_enabled"
                    value="1"
                    {{ $publicFeedbackEnabled ? 'checked' : '' }}
                    class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                >
                <label for="public_feedback_enabled" class="ml-2 block text-sm text-gray-900">
                    Aktifkan Formulir Umpan Balik Publik
                </label>
            </div>

            <div class="mt-6 flex justify-start">
                <button
                    type="submit"
                    class="bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-50 border-0"
                    style="background-color: #10b981 !important; color: white !important;">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
