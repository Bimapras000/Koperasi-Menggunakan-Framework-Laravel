<?php

namespace App\Exports;

use App\Models\Setor;
use Maatwebsite\Excel\Concerns\FromCollection;

class SetorExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Setor::with('users')->get();
        $setor = Setor::join('users','users_id','=','users.id')
        ->select('setor.tgl_setor','users.name as users','setor.nominal','setor.nominal','setor.konfirmasi')
        ->get();
        return $setor;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama',
            'Nominal',
            'Jenis Setor',
            'Status'
        ];
    }

    
    
}
