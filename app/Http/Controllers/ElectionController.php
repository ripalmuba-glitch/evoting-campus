<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    /**
     * Menampilkan daftar pemilihan.
     */
    public function index()
    {
        // Ambil data terbaru dulu
        $elections = Election::latest()->paginate(10);
        return view('admin.elections.index', compact('elections'));
    }

    /**
     * Menampilkan form tambah pemilihan.
     */
    public function create()
    {
        return view('admin.elections.create');
    }

    /**
     * Menyimpan data pemilihan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date', // Tanggal selesai wajib setelah mulai
        ]);

        Election::create($request->all());

        return redirect()->route('elections.index')
            ->with('status', 'Pemilihan berhasil dibuat!');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Election $election)
    {
        return view('admin.elections.edit', compact('election'));
    }

    /**
     * Update data pemilihan.
     */
    public function update(Request $request, Election $election)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,closed',
        ]);

        $election->update($request->all());

        return redirect()->route('elections.index')
            ->with('status', 'Data pemilihan berhasil diperbarui!');
    }

    /**
     * Hapus pemilihan.
     */
    public function destroy(Election $election)
    {
        $election->delete();

        return redirect()->route('elections.index')
            ->with('status', 'Pemilihan berhasil dihapus!');
    }

    public function browseCandidates()
    {
        $elections = Election::withCount('candidates')->latest()->get();
        return view('admin.candidates.browse', compact('elections'));
    }
}
