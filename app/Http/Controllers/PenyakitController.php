<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use App\Models\Gejala; // Import Gejala model for many-to-many relationship
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Already handled by model booted method, but good to remember

class PenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyakits = Penyakit::with('gejalas')->latest()->paginate(10); // Eager load gejalas
        return view('penyakits.index', compact('penyakits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gejalas = Gejala::all(); // Get all symptoms to allow selection for a new disease
        return view('penyakits.create', compact('gejalas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_penyakit' => 'required|string|max:255|unique:penyakits,kode_penyakit',
            'nama_penyakit' => 'required|string|max:255|unique:penyakits,nama_penyakit',
            'deskripsi' => 'required|string',
            'solusi_umum' => 'nullable|string',
            'gejalas' => 'array', // Array of gejala IDs
            'gejalas.*' => 'exists:gejalas,id', // Each ID must exist in the gejalas table
        ]);

        $penyakit = Penyakit::create($request->except('gejalas')); // Create Penyakit without gejalas first

        // Attach selected symptoms
        if ($request->has('gejalas')) {
            $penyakit->gejalas()->attach($request->input('gejalas'));
        }

        return redirect()->route('penyakits.index')->with('success', 'Penyakit created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penyakit $penyakit)
    {
        $penyakit->load('gejalas', 'solusi', 'kasus'); // Eager load relationships for display
        return view('penyakits.show', compact('penyakit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penyakit $penyakit)
    {
        $gejalas = Gejala::all();
        // Get the IDs of symptoms already associated with this disease
        $selectedGejalaIds = $penyakit->gejalas->pluck('id')->toArray();

        return view('penyakits.edit', compact('penyakit', 'gejalas', 'selectedGejalaIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penyakit $penyakit)
    {
        $request->validate([
            'kode_penyakit' => 'required|string|max:255|unique:penyakits,kode_penyakit,' . $penyakit->id,
            'nama_penyakit' => 'required|string|max:255|unique:penyakits,nama_penyakit,' . $penyakit->id,
            'deskripsi' => 'required|string',
            'solusi_umum' => 'nullable|string',
            'gejalas' => 'array',
            'gejalas.*' => 'exists:gejalas,id',
        ]);

        $penyakit->update($request->except('gejalas'));

        // Sync selected symptoms (detaches old ones, attaches new ones)
        if ($request->has('gejalas')) {
            $penyakit->gejalas()->sync($request->input('gejalas'));
        } else {
            // If no gejalas are selected, detach all existing ones
            $penyakit->gejalas()->detach();
        }

        return redirect()->route('penyakits.index')->with('success', 'Penyakit updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penyakit $penyakit)
    {
        // Detach related gejala before deleting the disease
        $penyakit->gejalas()->detach();
        // Also consider if you want to delete associated solusis, kasus, or diagnosas.
        // If they have foreign key constraints, you might need to handle them here or in a database cascade.
        // For example: $penyakit->solusi()->delete(); if it's a hasOne/hasMany.
        $penyakit->delete();

        return redirect()->route('penyakits.index')->with('success', 'Penyakit deleted successfully!');
    }
}