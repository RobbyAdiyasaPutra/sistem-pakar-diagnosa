<?php

namespace App\Http\Controllers;

use App\Models\Gejala; // Import the Gejala model
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gejalas = Gejala::latest()->paginate(10);
        return view('gejalas.index', compact('gejalas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gejalas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|string|max:255|unique:gejalas,kode_gejala', // Ensure unique code
            'nama_gejala' => 'required|string|max:255|unique:gejalas,nama_gejala', // Ensure unique name
            'kategori' => 'nullable|string|max:255', //
        ]);

        Gejala::create($request->all());

        return redirect()->route('gejalas.index')->with('success', 'Gejala created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gejala $gejala)
    {
        // You might eager load relationships if you want to show associated kasus or penyakits
        // $gejala->load('kasus', 'penyakits');
        return view('gejalas.show', compact('gejala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gejala $gejala)
    {
        return view('gejalas.edit', compact('gejala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gejala $gejala)
    {
        $request->validate([
            'kode_gejala' => 'required|string|max:255|unique:gejalas,kode_gejala,' . $gejala->id,
            'nama_gejala' => 'required|string|max:255|unique:gejalas,nama_gejala,' . $gejala->id,
            'kategori' => 'nullable|string|max:255',
        ]);

        $gejala->update($request->all());

        return redirect()->route('gejalas.index')->with('success', 'Gejala updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gejala $gejala)
    {
        // Consider if you need to detach related kasus or penyakits before deleting the symptom.
        // For example: $gejala->kasus()->detach(); $gejala->penyakits()->detach();
        $gejala->delete();

        return redirect()->route('gejalas.index')->with('success', 'Gejala deleted successfully!');
    }
}