<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Buku</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; }
        .summary { margin-bottom: 20px; font-size: 12px; }
        .summary table { width: 100%; border: none; }
        .summary td { padding: 3px; border: none; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .print-date { text-align: right; font-style: italic; font-size: 11px; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Peminjaman Buku</h2>
        <p>E-Perpustakaan System</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td style="width: 15%;"><strong>Filter Tanggal:</strong></td>
                <td style="width: 35%;">{{ $dari ? \Carbon\Carbon::parse($dari)->format('d/m/Y') : 'Awal' }} - {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d/m/Y') : 'Akhir' }}</td>
                <td style="width: 25%;"><strong>Total Transaksi:</strong></td>
                <td style="width: 25%;">{{ $totalTransaksi }}</td>
            </tr>
            <tr>
                <td><strong>Filter Status:</strong></td>
                <td>{{ ucfirst($status ?? 'Semua Status') }}</td>
                <td><strong>Sedang Dipinjam:</strong></td>
                <td>{{ $totalDipinjam }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Telah Dikembalikan:</strong></td>
                <td>{{ $totalDikembalikan }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Peminjam</th>
                <th style="width: 30%;">Judul Buku</th>
                <th style="width: 15%;">Tgl Pinjam</th>
                <th style="width: 15%;">Tgl Kembali</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $trx->member->nama }}</td>
                <td>{{ $trx->book->judul }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d/m/Y') }}</td>
                <td class="text-center">{{ $trx->tanggal_kembali ? \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d/m/Y') : '-' }}</td>
                <td class="text-center">{{ ucfirst($trx->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi yang sesuai.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="print-date">
        Dicetak pada: {{ date('d M Y H:i:s') }}
    </div>

</body>
</html>
