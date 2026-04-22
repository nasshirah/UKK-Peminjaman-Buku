<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Peminjaman Buku</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        h3 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; color: #555; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h3>Laporan Riwayat Peminjaman Buku</h3>
    <p>E-Perpustakaan System</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Judul Buku</th>
                <th style="width: 20%;">Tanggal Pinjam</th>
                <th style="width: 20%;">Tanggal Kembali</th>
                <th style="width: 20%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $trx->book->judul }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}</td>
                <td class="text-center">{{ $trx->tanggal_kembali ? \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') : '-' }}</td>
                <td class="text-center">{{ ucfirst($trx->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada riwayat peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
