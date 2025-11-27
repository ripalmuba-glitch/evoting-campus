<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\VotersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VoterManagementController extends Controller
{
    public function index()
    {
        // Ambil user yang role-nya 'voter' saja
        $voters = User::where('role', 'voter')->latest()->paginate(15);
        return view('admin.voters.index', compact('voters'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new VotersImport, $request->file('file'));
            return redirect()->back()->with('status', 'Data pemilih berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Gagal import: ' . $e->getMessage()]);
        }
    }

    public function destroy(User $voter)
    {
        $voter->delete();
        return redirect()->back()->with('status', 'Data pemilih dihapus.');
    }
}
