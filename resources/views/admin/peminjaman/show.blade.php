@extends('admin.layout.appadmin')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h3>Detail Pinjaman</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $user->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Alamat:</strong> {{ $user->alamat }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nomor Telepon:</strong> {{ $user->no_tlp }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nominal:</strong> {{ $peminjaman->nominal }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Pinjaman:</strong> {{ $peminjaman->tgl_pinjaman }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Tanggal Pengembalian:</strong> {{ $peminjaman->tgl_pengembalian }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Bunga:</strong> {{ $peminjaman->bunga }}%</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Total:</strong> {{ $peminjaman->total }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Pembayaran Bulanan:</strong> {{ $monthlyPayment }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="{{ url('admin/peminjaman') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
