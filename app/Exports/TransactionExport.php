<?php

namespace App\Exports;

use App\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;

// class TransactionExport implements FromCollection, WithMapping, WithHeadings
class TransactionExport implements FromView
{

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    private $status;

    public function setStatus($status){
        $this->status = $status;
    }


    public function view(): View
    {
        return view('backend.transaction.export', [
            'transaction' => $this->transaction->where('status',$this->status)->get()
        ]);
    }

    // public function map($transaction): array
    // {
    //     return [
    //         $transaction->invoice_no,
    //         Carbon::parse($transaction->date)->format('Y-m-d'),
    //         Carbon::parse($transaction->date)->format('H:i:s'),
    //         $transaction->customer->name,
    //         $transaction->amount,
    //         $transaction->status
    //     ];
    // }

    // public function headings(): array{
    //     return [
    //         ['Invoice', 'Tanggal','Waktu','Pelanggan','Total','Status']
    //     ];
    // }
}
