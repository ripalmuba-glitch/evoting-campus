<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Pemilihan</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        .subtitle { font-size: 14px; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .winner { background-color: #e6fffa; }
        .footer { margin-top: 50px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">BERITA ACARA HASIL PEMILIHAN</div>
        <div class="title">{{ $election->title }}</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($election->start_date)->format('d M Y') }} s/d
            {{ \Carbon\Carbon::parse($election->end_date)->format('d M Y') }}
        </div>
    </div>

    <p>Berdasarkan hasil pemungutan suara elektronik (e-Voting) yang telah dilaksanakan, berikut adalah rincian perolehan suara:</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Nama Kandidat</th>
                <th style="width: 20%">Jumlah Suara</th>
                <th style="width: 20%">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($election->candidates as $index => $candidate)
            <tr class="{{ $index == 0 ? 'winner' : '' }}">
                <td>{{ $index + 1 }}</td>
                <td>
                    {{ $candidate->name }}
                    @if($index == 0) <b>(TERPILIH)</b> @endif
                </td>
                <td>{{ $candidate->total_votes }}</td>
                <td>
                    {{ $totalVotes > 0 ? number_format(($candidate->total_votes / $totalVotes) * 100, 1) : 0 }}%
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" style="text-align: right">Total Partisipasi Suara</th>
                <th>{{ $totalVotes }}</th>
                <th>100%</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
        <p>Mengetahui,<br>Administrator Sistem</p>
        <br><br><br>
        <p>( _______________________ )</p>
    </div>
</body>
</html>
