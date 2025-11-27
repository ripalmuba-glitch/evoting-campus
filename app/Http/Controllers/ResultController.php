<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua data pemilihan untuk dropdown filter
        $elections = Election::latest()->get();

        $selectedElection = null;
        $candidates = [];
        $chartLabels = [];
        $chartData = [];

        // Jika Admin memilih salah satu pemilihan
        if ($request->has('election_id')) {
            $selectedElection = Election::with(['candidates' => function($query) {
                // Urutkan kandidat berdasarkan suara terbanyak
                $query->orderBy('total_votes', 'desc');
            }])->find($request->election_id);

            if ($selectedElection) {
                // Siapkan data untuk Chart.js
                $candidates = $selectedElection->candidates;
                $chartLabels = $candidates->pluck('name')->toArray(); // Nama Kandidat
                $chartData = $candidates->pluck('total_votes')->toArray(); // Jumlah Suara
            }
        }

        return view('admin.results.index', compact('elections', 'selectedElection', 'chartLabels', 'chartData'));
    }
}
