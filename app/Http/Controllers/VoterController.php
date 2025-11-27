<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;

class VoterController extends Controller
{
    public function dashboard()
    {
        // Ambil pemilihan yang sedang aktif saja
        $activeElections = Election::where('status', 'active')->get();

        return view('voter.dashboard', compact('activeElections'));
    }
}
