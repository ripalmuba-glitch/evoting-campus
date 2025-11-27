<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    /**
     * Menampilkan Halaman Bilik Suara (Daftar Kandidat di Pemilihan Tertentu)
     */
    public function show(Election $election)
    {
        // 1. Cek apakah user sudah memilih di pemilihan ini?
        $hasVoted = Vote::where('voter_id', Auth::id())
                        ->where('election_id', $election->id)
                        ->exists();

        if ($hasVoted) {
            return redirect()->route('voter.dashboard')
                ->with('error', 'Anda sudah memberikan suara pada pemilihan ini!');
        }

        // 2. Cek apakah pemilihan masih aktif?
        if ($election->status !== 'active') {
            return redirect()->route('voter.dashboard')
                ->with('error', 'Pemilihan ini sudah ditutup.');
        }

        return view('voter.show', compact('election'));
    }

    /**
     * Proses Simpan Suara (COBLOS)
     */
    public function store(Request $request, Election $election)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $user = Auth::user();

        // VALIDASI GANDA (Security Layer)
        // Cek lagi di server, jangan cuma di tampilan
        $checkVote = Vote::where('voter_id', $user->id)
                         ->where('election_id', $election->id)
                         ->exists();

        if ($checkVote) {
            return redirect()->back()->with('error', 'Curang terdeteksi! Anda sudah memilih sebelumnya.');
        }

        // DATABASE TRANSACTION
        // Menjamin semua proses sukses. Jika satu gagal, semua dibatalkan.
        DB::transaction(function () use ($request, $election, $user) {

            // 1. Simpan Rekam Jejak Suara
            Vote::create([
                'election_id' => $election->id,
                'candidate_id' => $request->candidate_id,
                'voter_id' => $user->id,
            ]);

            // 2. Tambahkan Counter Suara di Kandidat (Agar query hasil cepat)
            $candidate = Candidate::find($request->candidate_id);
            $candidate->increment('total_votes');

            // 3. Tandai User Sudah Memilih (Global Flag)
            $user->update(['is_voted' => true]);
        });

        return redirect()->route('voter.dashboard')
            ->with('success', 'Terima kasih! Suara Anda berhasil direkam. Hak pilih Anda sangat berarti.');
    }
}
