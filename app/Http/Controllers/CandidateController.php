<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    // Menampilkan daftar kandidat berdasarkan ID Pemilihan
    public function index(Election $election)
    {
        // Ambil kandidat yang hanya milik pemilihan ini
        $candidates = $election->candidates;
        return view('admin.candidates.index', compact('election', 'candidates'));
    }

    // Form tambah kandidat
    public function create(Election $election)
    {
        return view('admin.candidates.create', compact('election'));
    }

    // Simpan kandidat baru
    public function store(Request $request, Election $election)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vision_mission' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Proses Upload Foto
        $photoPath = $request->file('photo')->store('candidates', 'public');

        // Simpan ke Database
        $election->candidates()->create([
            'name' => $request->name,
            'vision_mission' => $request->vision_mission,
            'photo' => $photoPath,
        ]);

        return redirect()->route('elections.candidates.index', $election->id)
            ->with('status', 'Kandidat berhasil ditambahkan!');
    }

    // Hapus kandidat
    public function destroy(Election $election, Candidate $candidate)
    {
        // Hapus file foto dari penyimpanan agar tidak menumpuk sampah
        if ($candidate->photo) {
            Storage::disk('public')->delete($candidate->photo);
        }

        $candidate->delete();

        return redirect()->route('elections.candidates.index', $election->id)
            ->with('status', 'Kandidat berhasil dihapus!');
    }
}
