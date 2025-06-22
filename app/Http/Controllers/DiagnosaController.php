<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use App\Models\User;     // Don't forget to import User if needed for dropdowns or user filtering
use App\Models\Penyakit; // Don't forget to import Penyakit
use App\Models\Gejala;   // Don't forget to import Gejala for the diagnostic logic
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // To get the authenticated user

class DiagnosaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Often, this will show diagnoses for the authenticated user, or all for admin.
     */
    public function index()
    {
        // For a regular user, show only their diagnoses
        if (Auth::check() && Auth::user()->isUser()) {
            $diagnosas = Diagnosa::where('user_id', Auth::id())->latest()->paginate(10);
        } else {
            // For admin, show all diagnoses
            $diagnosas = Diagnosa::with(['user', 'penyakit'])->latest()->paginate(10);
        }

        return view('diagnosas.index', compact('diagnosas'));
    }

    /**
     * Show the form for creating a new resource (e.g., selecting symptoms).
     */
    public function create()
    {
        $gejalas = Gejala::all(); // Get all symptoms to display for user selection
        return view('diagnosas.create', compact('gejalas'));
    }

    /**
     * Store a newly created resource in storage.
     * This is where the core diagnostic logic will reside.
     */
    public function store(Request $request)
    {
        // 1. Validate incoming request (e.g., selected symptoms)
        $request->validate([
            'gejala_terpilih' => 'required|array|min:1', // Ensure at least one symptom is selected
            'gejala_terpilih.*' => 'exists:gejalas,id', // Ensure all selected symptom IDs exist
            // You might have input for `metadata` as well
        ]);

        // Ensure user is authenticated to link diagnosis
        if (!Auth::check()) {
            return redirect()->back()->withErrors('You must be logged in to perform a diagnosis.');
        }

        $userId = Auth::id();
        $gejalaTerpilihIds = $request->input('gejala_terpilih');
        $selectedGejalas = Gejala::whereIn('id', $gejalaTerpilihIds)->get();

        // 2. Implement your diagnostic logic here (e.g., Certainty Factor, Naive Bayes, etc.)
        // This is a placeholder for your actual algorithm.

        $hasilDiagnosa = 'Belum Didiagnosa'; // Default
        $rekomendasi = 'Silakan hubungi ahli.'; // Default
        $similarityScore = 0;
        $cfValue = 0;
        $penyakitId = null; // Determined by your diagnosis logic

        // --- START: Placeholder for actual diagnostic algorithm ---
        // Example: Simple matching (Highly simplified for demonstration)
        $penyakits = Penyakit::with('gejalas')->get(); // Load diseases with their associated symptoms

        $bestMatchPenyakit = null;
        $highestMatchCount = 0;

        foreach ($penyakits as $penyakit) {
            $matchCount = 0;
            foreach ($selectedGejalas as $selectedGejala) {
                if ($penyakit->gejalas->contains($selectedGejala)) {
                    $matchCount++;
                }
            }

            if ($matchCount > $highestMatchCount) {
                $highestMatchCount = $matchCount;
                $bestMatchPenyakit = $penyakit;
            }
        }

        if ($bestMatchPenyakit) {
            $penyakitId = $bestMatchPenyakit->id;
            $hasilDiagnosa = 'Kemungkinan besar: ' . $bestMatchPenyakit->nama_penyakit;
            $rekomendasi = $bestMatchPenyakit->solusi_umum ?? 'Tidak ada rekomendasi umum tersedia.';
            // Calculate a simple similarity score based on matched symptoms vs total selected or total disease symptoms
            $totalSelected = count($selectedGejalas);
            $totalDiseaseSymptoms = $bestMatchPenyakit->gejalas->count();
            if ($totalSelected > 0) {
                 $similarityScore = ($matchCount / $totalSelected) * 100;
            } else {
                $similarityScore = 0;
            }

            // Implement your CF logic here
            // $cfValue = calculateCertaintyFactor($selectedGejalas, $bestMatchPenyakit);
        }
        // --- END: Placeholder for actual diagnostic algorithm ---


        // 3. Create the Diagnosa record
        $diagnosa = Diagnosa::create([
            'user_id' => $userId,
            'penyakit_id' => $penyakitId, // This comes from your diagnostic logic
            'gejala_terpilih' => $gejalaTerpilihIds,
            'similarity_score' => $similarityScore,
            'cf_value' => $cfValue, // Populate this from your CF calculation
            'hasil_diagnosa' => $hasilDiagnosa,
            'rekomendasi' => $rekomendasi,
            'metadata' => $request->input('metadata', []), // Any additional data
        ]);

        return redirect()->route('diagnosas.show', $diagnosa->id)->with('success', 'Diagnosa berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diagnosa $diagnosa)
    {
        // Ensure user can only view their own diagnoses unless they are admin
        if (Auth::check() && Auth::user()->isUser() && $diagnosa->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // The accessor getGejalaTerpilihDetailAttribute will automatically load details
        return view('diagnosas.show', compact('diagnosa'));
    }

    /**
     * Show the form for editing the specified resource.
     * (Often not needed for diagnoses, as they are results)
     */
    public function edit(Diagnosa $diagnosa)
    {
        // This method might be restricted or display only certain fields for correction/notes by admin
        // Or simply forbidden for regular users.
        if (Auth::check() && Auth::user()->isUser()) {
             abort(403, 'Unauthorized action.');
        }
        $gejalas = Gejala::all();
        $penyakits = Penyakit::all();
        return view('diagnosas.edit', compact('diagnosa', 'gejalas', 'penyakits'));
    }

    /**
     * Update the specified resource in storage.
     * (Often not needed for diagnoses)
     */
    public function update(Request $request, Diagnosa $diagnosa)
    {
        if (Auth::check() && Auth::user()->isUser()) {
             abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'penyakit_id' => 'nullable|exists:penyakits,id', // Can be null if diagnosis is inconclusive
            'gejala_terpilih' => 'required|array',
            'gejala_terpilih.*' => 'exists:gejalas,id',
            'similarity_score' => 'nullable|numeric',
            'cf_value' => 'nullable|numeric',
            'hasil_diagnosa' => 'required|string|max:255',
            'rekomendasi' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        $diagnosa->update($request->all());

        return redirect()->route('diagnosas.show', $diagnosa->id)->with('success', 'Diagnosa updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * (Typically restricted to admins or for data cleanup)
     */
    public function destroy(Diagnosa $diagnosa)
    {
        if (Auth::check() && Auth::user()->isUser()) {
             abort(403, 'Unauthorized action.');
        }
        $diagnosa->delete();

        return redirect()->route('diagnosas.index')->with('success', 'Diagnosa deleted successfully!');
    }
}