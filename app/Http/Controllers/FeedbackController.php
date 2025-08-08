<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Masjid;
use App\Models\Penceramah;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use League\Csv\Writer;
use Illuminate\Support\Facades\Response;

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
                'preacher_name' => 'nullable|string|max:255',
                'mosque_name' => 'nullable|string|max:255|required_without:imapp_id_masjid',
                'imapp_id_penceramah' => 'nullable|integer',
                'imapp_id_masjid' => 'nullable|integer|required_without:mosque_name',
                'relevance_rating' => 'required|integer|min:1|max:5',
                'clarity_rating' => 'required|integer|min:1|max:5',
                'understanding_rating' => 'required|integer|min:1|max:5',
                'timing_rating' => 'required|integer|min:1|max:5',
                'interaction_rating' => 'nullable|integer|min:0|max:5',
                'suggestions' => 'required|string|max:1000',
            ],
            [
                'preacher_name.max' => 'Nama penceramah tidak boleh lebih dari 255 karakter.',
                'preacher_name.required_without' => 'Nama penceramah wajib diisi.',
                'mosque_name.max' => 'Nama masjid tidak boleh lebih dari 255 karakter.',
                'mosque_name.required_without' => 'Nama masjid wajib diisi.',
                'imapp_id_penceramah.required_without' => 'ID penceramah wajib diisi.',
                'imapp_id_masjid.required_without' => 'ID masjid wajib diisi.',
                'relevance_rating.required' => 'Rating relevansi materi dakwah wajib dipilih.',
                'relevance_rating.integer' => 'Rating relevansi harus berupa angka.',
                'relevance_rating.min' => 'Rating relevansi minimal 1 bintang.',
                'relevance_rating.max' => 'Rating relevansi maksimal 5 bintang.',
                'clarity_rating.required' => 'Rating kejelasan penyampaian wajib dipilih.',
                'clarity_rating.integer' => 'Rating kejelasan harus berupa angka.',
                'clarity_rating.min' => 'Rating kejelasan minimal 1 bintang.',
                'clarity_rating.max' => 'Rating kejelasan maksimal 5 bintang.',
                'understanding_rating.required' => 'Rating pemahaman jamaah wajib dipilih.',
                'understanding_rating.integer' => 'Rating pemahaman harus berupa angka.',
                'understanding_rating.min' => 'Rating pemahaman minimal 1 bintang.',
                'understanding_rating.max' => 'Rating pemahaman maksimal 5 bintang.',
                'timing_rating.required' => 'Rating kesesuaian waktu wajib dipilih.',
                'timing_rating.integer' => 'Rating kesesuaian waktu harus berupa angka.',
                'timing_rating.min' => 'Rating kesesuaian waktu minimal 1 bintang.',
                'timing_rating.max' => 'Rating kesesuaian waktu maksimal 5 bintang.',
                'interaction_rating.required' => 'Rating interaksi jamaah wajib dipilih.',
                'interaction_rating.integer' => 'Rating interaksi harus berupa angka.',
                'interaction_rating.min' => 'Rating interaksi minimal 1 bintang.',
                'interaction_rating.max' => 'Rating interaksi maksimal 5 bintang.',
                'suggestions.required' => 'Saran/Kesan wajib diisi.',
                'suggestions.max' => 'Saran tidak boleh lebih dari 1000 karakter.',
            ],
        );

        // Map form input names to database column names
        $data = [
            'imapp_id_penceramah' => $validated['imapp_id_penceramah'],
            'imapp_id_masjid' => $validated['imapp_id_masjid'],
            'nama_penceramah' => $validated['preacher_name'],
            'nama_masjid' => $validated['mosque_name'],
            'relevansi_rating' => $validated['relevance_rating'],
            'kejelasan_rating' => $validated['clarity_rating'],
            'pemahaman_jamaah_rating' => $validated['understanding_rating'],
            'kesesuaian_waktu_rating' => $validated['timing_rating'],
            'saran' => $validated['suggestions'],
        ];

        if (isset($validated['interaction_rating'])) {
            $data['interaksi_jamaah_rating'] = $validated['interaction_rating'] ?? null;
        }

        Feedback::create($data);

        return redirect()->route('feedback.create')->with('success', 'Terima kasih atas feedback Anda! Masukan Anda sangat berharga bagi kami.');
    }

    /**
     * Display feedbacks (filtered by role)
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Feedback::query();

        // If user is penceramah, filter by their ID
        if ($user->isPenceramah()) {
            $query->where('imapp_id_penceramah', $user->id_penceramah);
        }

        // If user is pengurus_masjid, filter by their masjid ID
        if ($user->isPengurusMasjid()) {
            $query->where('imapp_id_masjid', $user->id_masjid);
        }

        // Filter by ratings if provided
        if ($request->filled('relevansi_rating')) {
            $query->byRelevansiRating($request->relevansi_rating);
        }
        if ($request->filled('kejelasan_rating')) {
            $query->byKejelasanRating($request->kejelasan_rating);
        }
        if ($request->filled('pemahaman_jamaah_rating')) {
            $query->byPemahamanJamaahRating($request->pemahaman_jamaah_rating);
        }
        if ($request->filled('kesesuaian_waktu_rating')) {
            $query->byKesesuaianWaktuRating($request->kesesuaian_waktu_rating);
        }
        if ($request->filled('interaksi_jamaah_rating')) {
            $query->byInteraksiJamaahRating($request->interaksi_jamaah_rating);
        }

        // Search by name or comment
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_penceramah', 'like', "%{$search}%")
                    ->orWhere('nama_masjid', 'like', "%{$search}%")
                    ->orWhere('saran', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSorts = ['created_at', 'nama_penceramah', 'nama_masjid', 'relevansi_rating', 'kejelasan_rating', 'pemahaman_jamaah_rating', 'kesesuaian_waktu_rating', 'interaksi_jamaah_rating'];
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

    public function autocompletePenceramah(Request $request)
    {
        $query = $request->input('q');
        $penceramah = Penceramah::where('nama_penceramah', 'like', "%{$query}%")
            ->select('id as imapp_id_penceramah', 'nama_penceramah as text')
            ->limit(10)
            ->get();

        return response()->json(['results' => $penceramah]);
    }

    public function autocompleteMasjid(Request $request)
    {
        $query = $request->input('q');
        $masjid = Masjid::where('nama_masjid', 'like', "%{$query}%")
            ->select('id as imapp_id_masjid', 'nama_masjid as text')
            ->limit(10)
            ->get();

        return response()->json(['results' => $masjid]);
    }


    public function export()
    {
        $columns = [
            // 'imapp_id_penceramah' => 'ID Penceramah',
            // 'imapp_id_masjid' => 'ID Masjid',
            'nama_penceramah' => 'Nama Penceramah',
            'nama_masjid' => 'Nama Masjid',
            'relevansi_rating' => 'Relevansi Rating',
            'kejelasan_rating' => 'Kejelasan Rating',
            'pemahaman_jamaah_rating' => 'Pemahaman Jamaah Rating',
            'kesesuaian_waktu_rating' => 'Kesesuaian Waktu Rating',
            'interaksi_jamaah_rating' => 'Interaksi Jamaah Rating',
            'saran' => 'Saran',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diperbarui',
        ];

        return view('dashboard.feedbacks.export', compact('columns'));
    }

    public function exportCsv(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'columns' => 'required|array|min:1',
            'columns.*' => 'in:nama_penceramah,imapp_id_penceramah,nama_masjid,imapp_id_masjid,relevansi_rating,kejelasan_rating,pemahaman_jamaah_rating,kesesuaian_waktu_rating,interaksi_jamaah_rating,saran,created_at,updated_at',
        ]);

        $query = Feedback::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $columns = $request->columns;
        $feedbacks = $query->select($columns)->get();

        $csv = Writer::createFromString();
        $csv->insertOne($columns);

        foreach ($feedbacks as $feedback) {
            $row = [];
            foreach ($columns as $column) {
                $value = $feedback->$column;
                if (in_array($column, ['created_at', 'updated_at']) && $value) {
                    // Format as RFC3339 (ATOM in PHP)
                    $value = $value->format(\DateTime::RFC3339);
                }
                $row[] = $value ?? '';
            }
            $csv->insertOne($row);
        }

        $filename = 'feedback_' . now()->format('Ymd_His') . '.csv';

        return Response::streamDownload(
            function () use ($csv) {
                echo $csv->toString();
            },
            $filename,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]
        );
    }
}
