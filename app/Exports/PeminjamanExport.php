<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;

class PeminjamanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
            ->select('users.name as nama','users.alamat as alamat','users.no_tlp as no_tlp', 'peminjaman.keperluan', 'peminjaman.nominal', 'peminjaman.tgl_pinjaman', 'peminjaman.tgl_pengembalian', 'peminjaman.total',)
            ->get();
        // return Peminjaman::with('users')->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Alamat',
            'Nomer Telepon',
            'Keperluan',
            'Nominal',
            'Tanggal Peminjaman',
            'Tanggal Pengembalian',
            'Total',
            
        ];
    }
}
