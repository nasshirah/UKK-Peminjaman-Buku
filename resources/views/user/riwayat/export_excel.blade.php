<table>
    <thead>
        <tr>
            <th colspan="5" style="font-weight: bold; font-size: 14px; text-align: center;">LAPORAN RIWAYAT PEMINJAMAN BUKU</th>
        </tr>
        <tr>
            <th colspan="5"></th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #f2f2f2; text-align: center;">No</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Judul Buku</th>
            <th style="font-weight: bold; background-color: #f2f2f2; text-align: center;">Tanggal Pinjam</th>
            <th style="font-weight: bold; background-color: #f2f2f2; text-align: center;">Tanggal Kembali</th>
            <th style="font-weight: bold; background-color: #f2f2f2; text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $trx)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td>{{ $trx->book->judul }}</td>
            <td style="text-align: center;">{{ $trx->tanggal_pinjam }}</td>
            <td style="text-align: center;">{{ $trx->tanggal_kembali ?? '-' }}</td>
            <td style="text-align: center;">{{ ucfirst($trx->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
