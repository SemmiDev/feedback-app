<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/autocomplete/penceramah', [FeedbackController::class, 'autocompletePenceramah'])->name('autocomplete.penceramah');
Route::get('/autocomplete/masjid', [FeedbackController::class, 'autocompleteMasjid'])->name('autocomplete.masjid');


// Dashboard routes - accessible by both admin and penceramah with role-based filtering
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/feedbacks/export', [FeedbackController::class, 'export'])->name('feedbacks.export');
        Route::post('/feedbacks/export', [FeedbackController::class, 'exportCsv'])->name('feedbacks.export.csv');
        Route::delete('/feedbacks/{feedback}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');

        // Settings routes
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.updateProfile');
        Route::post('/settings/application', [SettingController::class, 'updateApplicationSettings'])->name('settings.updateApplication');
    });

    Route::get('/feedbacks/{feedback}', [FeedbackController::class, 'show'])->name('feedbacks.show');

});

// Profile routes for penceramah only
Route::middleware(['auth', 'penceramah'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
