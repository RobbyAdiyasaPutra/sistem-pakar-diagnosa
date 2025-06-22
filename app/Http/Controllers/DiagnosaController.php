<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use App\Models\User;     // Import User model
use App\Models\Penyakit; // Import Penyakit model
use App\Models\Gejala;   // Import Gejala model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // To get the authenticated user

class DiagnosaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Admins see all diagnoses. Regular users see only their own.
     */
    public function index()
    {
        // Type-hint the authenticated user for IDE support
        /** @var User $user */
        $user = Auth::user();

        // If the user is a regular user (not admin), show only their diagnoses
        // Assuming isUser() method exists in your User model to check roles
        if ($user && method_exists($user, 'isUser') && $user->isUser()) {
            $diagnosas = Diagnosa::where('user_id', $user->id)
                                ->latest()
                                ->paginate(10);
        } else { // If the user is an admin or isUser() method doesn't exist (e.g., default user type)
            $diagnosas = Diagnosa::with(['user', 'penyakit'])
                                ->latest()
                                ->paginate(10);
        }

        return view('diagnosas.index', compact('diagnosas'));
    }

    /**
     * Show the form for creating a new resource (e.g., selecting symptoms).
     * Both admin and regular users can start a new diagnosis.
     */
    public function create()
    {
        // Ensure user is authenticated to start a diagnosis
        // This is typically handled by 'auth' middleware on the route,
        // but an explicit check here adds robustness.
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk memulai diagnosa.');
        }

        $gejalas = Gejala::all(); // Get all symptoms to display for user selection
        return view('diagnosas.create', compact('gejalas'));
    }

    /**
     * Store a newly created resource in storage.
     * Both admin and regular users can store a new diagnosis.
     */
    public function store(Request $request)
    {
        // 1. Validate incoming request (e.g., selected symptoms)
        $request->validate([
            'gejala_terpilih' => 'required|array|min:1', // Ensure at least one symptom is selected
            'gejala_terpilih.*' => 'exists:gejalas,id', // Ensure all selected symptom IDs exist
        ]);

        // Ensure user is authenticated to link diagnosis
        if (!Auth::check()) {
            return redirect()->back()->withErrors('Anda harus login untuk melakukan diagnosa.');
        }

        $userId = Auth::id();
        $gejalaTerpilihIds = $request->input('gejala_terpilih');
        $selectedGejalas = Gejala::whereIn('id', $gejalaTerpilihIds)->get();

        $hasilDiagnosa = 'Tidak dapat menentukan penyakit yang cocok berdasarkan gejala yang dipilih.';
        $rekomendasi = 'Coba pilih gejala lain atau hubungi ahli medis untuk diagnosa lebih lanjut.';
        $similarityScore = 0;
        $cfValue = 0; // Default, akan dihitung jika ada penyakit yang cocok
        $penyakitId = null; // Determined by your diagnosis logic

        // Load all diseases with their associated symptoms, ensuring pivot data (cf_value) is loaded
        $penyakits = Penyakit::with(['gejalas' => function($query) {
            $query->withPivot('cf_value'); // Make sure cf_value is loaded from pivot table
        }])->get();

        $bestMatchPenyakit = null;
        $highestMatchCount = 0;
        $bestSimilarity = 0;
        $bestMatchGejalaCfs = []; // To store CF values of matched symptoms for the best disease

        foreach ($penyakits as $penyakit) {
            $matchCount = 0;
            $currentPenyakitGejalaCfs = []; // CFs for symptoms matching *this* current disease

            foreach ($selectedGejalas as $selectedGejala) {
                // Find the associated symptom in the current disease's gejala collection
                $pivotGejala = $penyakit->gejalas->firstWhere('id', $selectedGejala->id);

                if ($pivotGejala) { // If the selected symptom is associated with this disease
                    $matchCount++;
                    // Add the CF value from the pivot table to our collection
                    if (isset($pivotGejala->pivot->cf_value)) {
                        $currentPenyakitGejalaCfs[] = (float) $pivotGejala->pivot->cf_value;
                    }
                }
            }

            // Simple similarity calculation (matched symptoms / total selected symptoms)
            $totalSelectedSymptoms = count($selectedGejalas);
            $currentSimilarity = ($totalSelectedSymptoms > 0) ? ($matchCount / $totalSelectedSymptoms) * 100 : 0;

            // Improve matching: prioritize diseases with more matches, then higher similarity
            if ($matchCount > $highestMatchCount || ($matchCount === $highestMatchCount && $currentSimilarity > $bestSimilarity)) {
                $highestMatchCount = $matchCount;
                $bestSimilarity = $currentSimilarity;
                $bestMatchPenyakit = $penyakit;
                $bestMatchGejalaCfs = $currentPenyakitGejalaCfs; // Store these CFs for the best match
            }
        }

        if ($bestMatchPenyakit) {
            $penyakitId = $bestMatchPenyakit->id;
            $hasilDiagnosa = 'Kemungkinan besar: ' . $bestMatchPenyakit->nama_penyakit;
            $rekomendasi = $bestMatchPenyakit->penanganan_umum ?? 'Tidak ada rekomendasi umum tersedia untuk penyakit ini.';
            $similarityScore = round($bestSimilarity, 2); // Round for display

            // HITUNG Certainty Factor (CF) di sini menggunakan CF dari gejala yang cocok
            if (!empty($bestMatchGejalaCfs)) {
                $cfValue = $this->calculateCombinedCertaintyFactor($bestMatchGejalaCfs);
            } else {
                $cfValue = 0; // Jika tidak ada gejala dengan CF yang cocok
            }

        } else {
            $hasilDiagnosa = 'Tidak dapat menentukan penyakit yang cocok berdasarkan gejala yang dipilih.';
            $rekomendasi = 'Coba pilih gejala lain atau hubungi ahli medis untuk diagnosa lebih lanjut.';
        }

        // 3. Create the Diagnosa record
        $diagnosa = Diagnosa::create([
            'user_id' => $userId,
            'penyakit_id' => $penyakitId,
            'gejala_terpilih' => $gejalaTerpilihIds, // Will be cast to array in model
            'similarity_score' => $similarityScore,
            'cf_value' => round($cfValue, 4), // Round CF value for storage
            'hasil_diagnosa' => $hasilDiagnosa,
            'rekomendasi' => $rekomendasi,
            'metadata' => $request->input('metadata', []), // Any additional data (ensure this is cast as array/json in model)
        ]);

        return redirect()->route('diagnosas.show', $diagnosa->id)->with('success', 'Diagnosa berhasil disimpan dan hasil ditampilkan!');
    }

    /**
     * Display the specified resource.
     * Admin can view any diagnosis. Regular user can only view their own.
     */
    public function show(Diagnosa $diagnosa)
    {
        /** @var User $user */
        $user = Auth::user();

        // If the user is a regular user (not admin) AND the diagnosis does not belong to them, abort.
        // Also check if isUser method exists before calling it
        if ($user && method_exists($user, 'isUser') && $user->isUser() && $diagnosa->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat diagnosa pengguna lain.');
        }

        // The accessor getGejalaTerpilihDetailAttribute in your Diagnosa model
        // should automatically load symptom details when $diagnosa->gejala_terpilih_detail is accessed.
        return view('diagnosas.show', compact('diagnosa'));
    }

    /**
     * Show the form for editing the specified resource.
     * Only admins can edit a diagnosis.
     */
    public function edit(Diagnosa $diagnosa)
    {
        /** @var User $user */
        $user = Auth::user();

        // Only admins can access the edit form
        if ($user && method_exists($user, 'isUser') && $user->isUser()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit diagnosa.');
        }

        $gejalas = Gejala::all();
        $penyakits = Penyakit::all();
        return view('diagnosas.edit', compact('diagnosa', 'gejalas', 'penyakits'));
    }

    /**
     * Update the specified resource in storage.
     * Only admins can update a diagnosis.
     */
    public function update(Request $request, Diagnosa $diagnosa)
    {
        /** @var User $user */
        $user = Auth::user();

        // Only admins can update
        if ($user && method_exists($user, 'isUser') && $user->isUser()) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui diagnosa.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'penyakit_id' => 'nullable|exists:penyakits,id', // Can be null if diagnosis is inconclusive
            'gejala_terpilih' => 'required|array',
            'gejala_terpilih.*' => 'exists:gejalas,id',
            'similarity_score' => 'nullable|numeric',
            'cf_value' => 'nullable|numeric',
            'hasil_diagnosa' => 'required|string|max:1000', // Increased max length
            'rekomendasi' => 'nullable|string|max:1000',    // Increased max length
            'metadata' => 'nullable', // Should be handled by model cast (array/json)
        ]);

        // Assuming your Diagnosa model has 'gejala_terpilih' and 'metadata' cast to 'array'
        $diagnosa->update($request->all());

        return redirect()->route('diagnosas.show', $diagnosa->id)->with('success', 'Diagnosa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Only admins can delete a diagnosis.
     */
    public function destroy(Diagnosa $diagnosa)
    {
        /** @var User $user */
        $user = Auth::user();

        // Only admins can delete
        if ($user && method_exists($user, 'isUser') && $user->isUser()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus diagnosa.');
        }

        $diagnosa->delete();

        return redirect()->route('diagnosas.index')->with('success', 'Diagnosa berhasil dihapus!');
    }

    /**
     * Helper function to calculate combined Certainty Factor.
     * Uses the CF_combine = CF1 + CF2 * (1 - CF1) for positive CFs.
     * Adjust this logic for handling negative CFs or more complex scenarios.
     *
     * @param array $cfs An array of certainty factor values (floats).
     * @return float The combined certainty factor.
     */
    protected function calculateCombinedCertaintyFactor(array $cfs): float
    {
        if (empty($cfs)) {
            return 0.0;
        }

        // Sort CFs to handle positive and negative combinations more robustly if desired.
        // For simplicity, this example processes them in order.
        $combinedCf = $cfs[0]; // Start with the first CF

        for ($i = 1; $i < count($cfs); $i++) {
            $cf1 = $combinedCf;
            $cf2 = $cfs[$i];

            // Implement CF combination rules based on signs
            if ($cf1 >= 0 && $cf2 >= 0) {
                $combinedCf = $cf1 + $cf2 * (1 - $cf1);
            } elseif ($cf1 < 0 && $cf2 < 0) {
                $combinedCf = $cf1 + $cf2 * (1 + $cf1);
            } else { // One positive, one negative
                if (abs($cf1) >= abs($cf2)) { // If absolute value of CF1 is greater
                    $combinedCf = $cf1 + $cf2 / (1 - $cf1);
                } else { // If absolute value of CF2 is greater
                    $combinedCf = $cf2 + $cf1 / (1 - $cf2);
                }
            }
        }

        // Ensure CF value remains between -1 and 1
        return max(-1.0, min(1.0, $combinedCf));
    }
}