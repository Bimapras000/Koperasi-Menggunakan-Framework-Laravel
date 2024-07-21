@extends('admin.layout.appadmin')

@section('content')
<div class="container">
    <h1>Ekspor PDF Berdasarkan Rentang Tanggal</h1>

    <form action="{{ route('export.pdf') }}" method="GET">
        <div class="form-group">
            <label for="data_type">Jenis Data</label>
            <select class="form-control" id="data_type" name="data_type" >
                <option value="">Pilih Jenis Data</option>
                <option value="setor">Data Setor</option>
                <option value="peminjaman">Riwayat Pinjaman</option>
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start_date" name="start_date" >
        </div>
        <div class="form-group">
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" class="form-control" id="end_date" name="end_date" >
        </div>
        <button type="submit" class="btn btn-primary">Ekspor PDF</button>
    </form>
</div>
@endsection
