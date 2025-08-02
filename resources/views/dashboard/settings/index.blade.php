@extends('layouts.dashboard')

@section('title', 'Settings')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Application Settings</h1>
    <p class="text-gray-600">Manage application configurations and user preferences.</p>
</div>

<!-- Profile Settings -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="px-4 py-5 sm:p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Profile Settings</h2>
        <p class="text-gray-600 mb-6">Update your account's profile information and password.</p>

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
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
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

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
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

            <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
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

            <!-- New Password -->
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
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

            <!-- Confirm New Password -->
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input
                    type="password"
                    name="new_password_confirmation"
                    id="new_password_confirmation"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                >
            </div>

            <div class="mt-6">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                >
                    Save Profile
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Application Settings -->
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Application Settings</h2>
        <p class="text-gray-600 mb-6">Configure general application settings.</p>

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
            <!-- App Name -->
            {{-- <div>
                <label for="app_name" class="block text-sm font-medium text-gray-700">Application Name</label>
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

            <!-- Public Feedback Form Toggle -->
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
                    Enable Public Feedback Form
                </label>
            </div>

            <div class="mt-6">
                <button
                    type="submit"
                    class="w-full bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-emerald-300 focus:ring-opacity-50 border-0"
                    style="background-color: #10b981 !important; color: white !important;">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
