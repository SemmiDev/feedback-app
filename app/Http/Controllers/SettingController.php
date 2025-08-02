<?php

namespace App\Http\Controllers;

use App\Models\Setting; // Import the Setting model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $appName = Setting::get('app_name', config('app.name'));
        $publicFeedbackEnabled = Setting::get('public_feedback_enabled', '1') === '1';

        return view('dashboard.settings.index', compact('appName', 'publicFeedbackEnabled'));
    }

    /**
     * Update the authenticated user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->username = $validated['username'];

        if (!empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->route('dashboard.settings.index')
            ->with('success_profile', 'Profile updated successfully!');
    }

    /**
     * Update application-wide settings.
     */
    public function updateApplicationSettings(Request $request)
    {
        $validated = $request->validate([
            'public_feedback_enabled' => 'sometimes|in:1',
        ]);

        // Ensure the key exists to avoid undefined array key error
        $validated['public_feedback_enabled'] = $validated['public_feedback_enabled'] ?? '0';

        Setting::set('public_feedback_enabled', $validated['public_feedback_enabled'] ? '1' : '0');

        return redirect()->route('dashboard.settings.index')
            ->with('success_application', 'Application settings updated successfully!');
    }
}
