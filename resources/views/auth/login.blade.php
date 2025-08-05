@extends('layouts.app')

@section('title', 'Masuk Admin')

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
                    Masuk ke <span class="font-semibold text-emerald-700">Panel Admin</span>
                </p>
            </div>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="bg-white shadow-xl rounded-lg p-6">
                <div class="space-y-6">
                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">
                            Username Pengguna
                        </label>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            required
                            value="{{ old('username') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('username') border-red-500 @enderror"
                            placeholder="Masukkan username Anda"
                        >
                        @error('username')
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
@endsection
