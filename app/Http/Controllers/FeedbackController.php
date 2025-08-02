<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    /**
     * Display feedback form for public users
     */
    public function create()
    {
        $publicFeedbackEnabled = Setting::get('public_feedback_enabled', '1') === '1';
        $appName = Setting::get('app_name', config('app.name'));

        return view('feedback.create', compact('publicFeedbackEnabled', 'appName'));
    }

    /**
     * Store feedback from public users
     */
    public function store(Request $request)
    {
        $publicFeedbackEnabled = Setting::get('public_feedback_enabled', '1') === '1';

        if (!$publicFeedbackEnabled) {
            return redirect()->route('feedback.create')->with('error', 'Form feedback saat ini tidak tersedia.');
        }

        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ],
            [
                'name.required' => 'Nama jamaah wajib diisi.',
                'name.max' => 'Nama jamaah tidak boleh lebih dari 255 karakter.',
                'rating.required' => 'Rating ceramah wajib dipilih.',
                'rating.integer' => 'Rating harus berupa angka.',
                'rating.min' => 'Rating minimal 1 bintang.',
                'rating.max' => 'Rating maksimal 5 bintang.',
                'comment.max' => 'Komentar tidak boleh lebih dari 1000 karakter.',
            ],
        );

        Feedback::create($validated);

        return redirect()->route('feedback.create')->with('success', 'Terima kasih atas feedback Anda! Masukan Anda sangat berharga bagi kami.');
    }

    /**
     * Display all feedbacks for admin
     */
    public function index(Request $request)
    {
        $query = Feedback::query();

        // Filter by rating if provided
        if ($request->filled('rating')) {
            $query->byRating($request->rating);
        }

        // Search by name or comment
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('comment', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSorts = ['created_at', 'name', 'rating'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $feedbacks = $query->paginate(10)->withQueryString();

        return view('dashboard.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show single feedback
     */
    public function show(Feedback $feedback)
    {
        return view('dashboard.feedbacks.show', compact('feedback'));
    }

    /**
     * Delete feedback
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('dashboard.feedbacks.index')->with('success', 'Feedback deleted successfully.');
    }
}
