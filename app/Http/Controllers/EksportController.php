<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Setor;
use PDF;

class EksportController extends Controller
{

    public function index(){
        
        return view('admin.eksport.eksportPDF');

    }

    public function exportPDF(Request $request)
    {
        $request->validate([
            'data_type' => 'required|string|in:setor,peminjaman',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $dataType = $request->input('data_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($dataType == 'peminjaman') {
            // Ambil data peminjaman berdasarkan rentang tanggal
            $data = Peminjaman::whereBetween('tgl_pinjaman', [$startDate, $endDate])->get();
            $view = 'admin.eksport.peminjaman_pdf';
        } else {
            // Ambil data setor berdasarkan rentang tanggal
            $data = Setor::whereBetween('tgl_setor', [$startDate, $endDate])->get();
            $view = 'admin.eksport.setor_pdf';
        }

        // Generate PDF
        $pdf = PDF::loadView($view, compact('data', 'startDate', 'endDate'));
        return $pdf->download($dataType . '.pdf');
    }
}
