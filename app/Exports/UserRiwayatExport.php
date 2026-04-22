<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserRiwayatExport implements FromView, ShouldAutoSize
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function view(): View
    {
        return view('user.riwayat.export_excel', [
            'transactions' => Transaction::with('book')
                ->where('member_id', $this->userId)
                ->latest()
                ->get()
        ]);
    }
}
