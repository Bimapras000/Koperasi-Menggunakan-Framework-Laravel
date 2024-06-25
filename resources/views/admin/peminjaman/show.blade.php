@extends('admin.layout.appadmin')

@section('content')
    <h3>Detail Pinjaman</h3>
    <div>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Alamat:</strong> {{ $user->alamat }}</p>
        <p><strong>Nomor Telepon:</strong> {{ $user->no_tlp }}</p>
        <p><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
        <p><strong>Nominal:</strong> {{ $peminjaman->nominal }}</p>
        <p><strong>Tanggal Pinjaman:</strong> {{ $peminjaman->tgl_pinjaman }}</p>
        <p><strong>Tanggal Pengembalian:</strong> {{ $peminjaman->tgl_pengembalian }}</p>
        <p><strong>Bunga:</strong> {{ $peminjaman->bunga }}%</p>
        <p><strong>Total:</strong> {{ $peminjaman->total }}</p>
        <p><strong>Pembayaran Bulanan:</strong> {{ $monthlyPayment }}</p>
    </div>
    <a href="{{ url('admin/peminjaman') }}" class="btn btn-secondary">Kembali</a>
@endsection
