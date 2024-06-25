@extends('admin.layout.appadmin')

@section('content')
<div class="container">
    <h1>Konfirmasi Peminjaman</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive table--no-card m-b-40" style="max-height: 450px; overflow-y: auto;">
        <table class="table table-borderless table-striped table-earning">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Pinjaman</th>
                <th>Tanggal Kembali</th>
                <th>Total Pinjaman</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1 @endphp
            @foreach ($pinjaman as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->users->name }}</td>
                    <td>{{ $item->tgl_pinjaman }}</td>
                    <td>{{ $item->tgl_pengembalian }}</td>
                    <td>{{ $item->total }}</td>
                    <td>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailModal" data-id="{{ $item->id }}">Detail</button>
                        <form action="{{ route('pinjaman.konfirmasi', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Konfirmasi</button>
                        </form>

                        <form action="{{ route('pinjaman.tolak' , $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </form>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama:</strong> <span id="detailNama"></span></p>
                    <p><strong>Alamat:</strong> <span id="detailAlamat"></span></p>
                    <p><strong>No Telepon:</strong> <span id="detailNoTlp"></span></p>
                    <p><strong>Keperluan:</strong> <span id="detailKeperluan"></span></p>
                    <p><strong>Tanggal Pinjaman:</strong> <span id="detailTglPinjaman"></span></p>
                    <p><strong>Tanggal Pengembalian:</strong> <span id="detailTglPengembalian"></span></p>
                    <p><strong>Nominal:</strong> <span id="detailNominal"></span></p>
                    <p><strong>Total:</strong> <span id="detailTotal"></span></p>
                    <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
