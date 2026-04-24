<table>
    <thead>
        <tr>
            <th colspan="6" style="font-weight: bold; font-size: 14px; text-align: center;">LAPORAN PEMINJAMAN BUKU PERPUSTAKAAN</th>
        </tr>
        <tr>
            <th colspan="6">Filter Tanggal: {{ $dari ? \Carbon\Carbon::parse($dari)->format('d/m/Y') : 'Awal' }} - {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d/m/Y') : 'Akhir' }}</th>
        </tr>
        <tr>
            <th colspan="6">Filter Status: {{ ucfirst($status ?? 'Semua Status') }}</th>
        </tr>
        <tr><th colspan="6"></th></tr>
        <tr>
            <th style="font-weight: bold; background-color: #f2f2f2; text-align: center;">No</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Peminjam</th>
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
            <td>{{ $trx->member->nama }}</td>
            <td>{{ $trx->book->judul }}</td>
            <td style="text-align: center;">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d/m/Y') }}</td>
            <td style="text-align: center;">
                @if($trx->pengembalian && $trx->status == 'selesai')
                    {{ \Carbon\Carbon::parse($trx->pengembalian->tanggal_kembali)->format('d/m/Y') }}
                @else
                    {{ $trx->tanggal_kembali ? \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d/m/Y') : '-' }}
                @endif
            </td>
            <td style="text-align: center;">{{ $trx->status == 'selesai' ? 'Dikembalikan' : ucfirst($trx->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
