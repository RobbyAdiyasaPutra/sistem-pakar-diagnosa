<?php

namespace App\Http\Controllers;

use App\Models\Solusi;   // Import Solusi model
use App\Models\Penyakit; // Import Penyakit model for relationship
use Illuminate\Http\Request;

class SolusiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the associated disease
        $solusis = Solusi::with('penyakit')->latest()->paginate(10);
        return view('solusis.index', compact('solusis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penyakits = Penyakit::all(); // Get all diseases for dropdown selection
        return view('solusis.create', compact('penyakits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penyakit_id' => 'required|exists:penyakits,id', // Must be linked to an existing disease
            'solusi' => 'required|string', // The solution text itself
            'tingkat_keparahan' => 'nullable|string|max:255', // e.g., "Ringan", "Sedang", "Parah"
            'langkah_langkah' => 'nullable|string', // Detailed steps
        ]);

        Solusi::create($request->all());

        return redirect()->route('solusis.index')->with('success', 'Solusi created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Solusi $solusi)
    {
        $solusi->load('penyakit'); // Eager load the associated disease
        return view('solusis.show', compact('solusi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solusi $solusi)
    {
        $penyakits = Penyakit::all();
        return view('solusis.edit', compact('solusi', 'penyakits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solusi $solusi)
    {
        $request->validate([
            'penyakit_id' => 'required|exists:penyakits,id',
            'solusi' => 'required|string',
            'tingkat_keparahan' => 'nullable|string|max:255',
            'langkah_langkah' => 'nullable|string',
        ]);

        $solusi->update($request->all());

        return redirect()->route('solusis.index')->with('success', 'Solusi updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solusi $solusi)
    {
        $solusi->delete();

        return redirect()->route('solusis.index')->with('success', 'Solusi deleted successfully!');
    }
}