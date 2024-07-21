<?php

namespace App\Exports;

use App\Models\Tabungan;
use Maatwebsite\Excel\Concerns\FromCollection;

class TabunganExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tabungan::join('users', 'users.id', '=', 'tabungan.users_id')
            ->select('users.name as nama', 'tabungan.saldo')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Saldo',
            
        ];
    }
}
