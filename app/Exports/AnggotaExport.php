<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnggotaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::whereIn('jabatan', ['anggota'])->get([
            'name', 'username', 'no_tlp', 'alamat'
        ]);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama', 'Username', 'Nomer Telepon', 'Alamat'
        ];
    }
}
