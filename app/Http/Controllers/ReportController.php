<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function print(Election $election)
    {
        // Load data kandidat urut suara terbanyak
        $election->load(['candidates' => function($q) {
            $q->orderBy('total_votes', 'desc');
        }]);

        $totalVotes = $election->candidates->sum('total_votes');

        $pdf = Pdf::loadView('admin.reports.pdf', compact('election', 'totalVotes'));

        // Download file dengan nama otomatis
        return $pdf->download('Laporan-Hasil-'.$election->title.'.pdf');
    }
}
