<?php

namespace App\Http\Controllers;

use App\Models\Kasus;    // Import Kasus model
use App\Models\Penyakit; // Import Penyakit model for relationship
use App\Models\Gejala;   // Import Gejala model for many-to-many relationship
use Illuminate\Http\Request;

class KasusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load penyakit and gejalas relationships
        $kasuses = Kasus::with(['penyakit', 'gejalas'])->latest()->paginate(10);
        return view('kasuses.index', compact('kasuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penyakits = Penyakit::all(); // For selecting the associated disease
        $gejalas = Gejala::all();     // For selecting associated symptoms
        return view('kasuses.create', compact('penyakits', 'gejalas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penyakit_id' => 'required|exists:penyakits,id', //
            'solusi' => 'nullable|string', //
            'keterangan' => 'nullable|string', //
            'gejalas' => 'array', // Array of gejala IDs for the many-to-many relationship
            'gejalas.*' => 'exists:gejalas,id', // Ensure each selected gejala ID exists
            // If 'tingkat_keparahan_gejala' is input per gejala, it needs specific validation
            // e.g., 'gejalas_pivot' => 'array', 'gejalas_pivot.*.gejala_id' => 'exists...', 'gejalas_pivot.*.tingkat_keparahan_gejala' => 'required|numeric'
        ]);

        $kasus = Kasus::create($request->except('gejalas')); // Create Kasus without gejalas first

        // Attach selected symptoms, potentially with pivot data
        if ($request->has('gejalas')) {
            $syncData = [];
            foreach ($request->input('gejalas') as $gejalaId) {
                // Assuming `tingkat_keparahan_gejala` is provided in the request
                // in a structure like: {'gejala_ids': [1,2,3], 'pivot_data': {'1': {'tingkat_keparahan_gejala': 'ringan'}}}
                // For simplicity, let's assume it's just a direct ID for now.
                // If you need `tingkat_keparahan_gejala` for each attached symptom, your form and request structure
                // will need to pass that data specifically.
                $syncData[$gejalaId] = ['tingkat_keparahan_gejala' => 'default_value']; // Replace with actual input
            }
            // A more robust way to handle pivot data when syncing:
            $gejalaIdsWithPivot = [];
            if ($request->has('gejala_pivot')) { // Assuming pivot data comes as 'gejala_pivot'
                 foreach ($request->input('gejala_pivot') as $item) {
                     $gejalaIdsWithPivot[$item['gejala_id']] = ['tingkat_keparahan_gejala' => $item['tingkat_keparahan_gejala']];
                 }
            } else {
                // If no specific pivot data, just attach the IDs
                foreach ($request->input('gejalas') as $gejalaId) {
                    $gejalaIdsWithPivot[$gejalaId] = []; // Attach without specific pivot data
                }
            }

            $kasus->gejalas()->sync($gejalaIdsWithPivot);
        } else {
            $kasus->gejalas()->detach(); // If no symptoms selected, remove all
        }

        return redirect()->route('kasuses.index')->with('success', 'Kasus created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kasus $kasus)
    {
        $kasus->load('penyakit', 'gejalas'); // Eager load relationships for display
        return view('kasuses.show', compact('kasus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kasus $kasus)
    {
        $penyakits = Penyakit::all();
        $gejalas = Gejala::all();
        // Get IDs of symptoms already associated with this case, including pivot data if needed
        $selectedGejalaIds = $kasus->gejalas->pluck('id')->toArray();
        // If you need pivot data for editing:
        // $selectedGejalasWithPivot = $kasus->gejalas->mapWithKeys(function($gejala) {
        //     return [$gejala->id => ['tingkat_keparahan_gejala' => $gejala->pivot->tingkat_keparahan_gejala]];
        // })->toArray();

        return view('kasuses.edit', compact('kasus', 'penyakits', 'gejalas', 'selectedGejalaIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kasus $kasus)
    {
        $request->validate([
            'penyakit_id' => 'required|exists:penyakits,id',
            'solusi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'gejalas' => 'array',
            'gejalas.*' => 'exists:gejalas,id',
        ]);

        $kasus->update($request->except('gejalas'));

        // Sync selected symptoms
        if ($request->has('gejalas')) {
             $gejalaIdsWithPivot = [];
            if ($request->has('gejala_pivot')) {
                 foreach ($request->input('gejala_pivot') as $item) {
                     $gejalaIdsWithPivot[$item['gejala_id']] = ['tingkat_keparahan_gejala' => $item['tingkat_keparahan_gejala']];
                 }
            } else {
                foreach ($request->input('gejalas') as $gejalaId) {
                    $gejalaIdsWithPivot[$gejalaId] = [];
                }
            }
            $kasus->gejalas()->sync($gejalaIdsWithPivot);
        } else {
            $kasus->gejalas()->detach();
        }

        return redirect()->route('kasuses.index')->with('success', 'Kasus updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kasus $kasus)
    {
        // Detach associated symptoms before deleting the case
        $kasus->gejalas()->detach();
        $kasus->delete();

        return redirect()->route('kasuses.index')->with('success', 'Kasus deleted successfully!');
    }
}