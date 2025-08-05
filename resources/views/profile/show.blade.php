@extends('layouts.dashboard')

@section('title', 'Profil')

@section('content')
<div class="container mx-auto">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Pengaturan Profil</h2>
            <p class="text-sm text-gray-600 mt-1">Perbarui informasi profil dan kata sandi Anda.</p>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username (readonly) -->
                <div class="mb-6">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pengguna
                    </label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        value="{{ $user->username }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror">
                </div>

                <!-- Kata Sandi Baru -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Kata Sandi Baru
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah kata sandi.</p>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Kata Sandi Baru -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                    >
                </div>

                <!-- Informasi Penceramah (jika ada) -->
                @if($user->isPenceramah() && $user->penceramah())
                    @php $penceramah = $user->penceramah(); @endphp
                    <div class="mb-6 p-4 bg-gray-50 rounded-md">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Informasi Penceramah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-600">No. HP:</span>
                                <span class="text-gray-800">{{ $penceramah->no_hp }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Tempat Lahir:</span>
                                <span class="text-gray-800">{{ $penceramah->tempat_lahir }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Tanggal Lahir:</span>
                                <span class="text-gray-800">{{ $penceramah->tanggal_lahir }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Pendidikan Terakhir:</span>
                                <span class="text-gray-800">{{ $penceramah->pendidikan_terakhir }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end space-x-1">
                    <a href="{{ route('dashboard.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white rounded-md shadow-sm transition-all duration-200 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 border-0"
                        style="background-color: #10b981 !important; color: white !important;">
                        Perbarui Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
