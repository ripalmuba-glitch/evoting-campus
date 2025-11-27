<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Election;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Kita siapkan data untuk statistik dashboard
        $totalVoters = User::where('role', 'voter')->count();
        $totalCandidates = Candidate::count();
        $totalElections = Election::count();

        return view('admin.dashboard', compact('totalVoters', 'totalCandidates', 'totalElections'));
    }
}
