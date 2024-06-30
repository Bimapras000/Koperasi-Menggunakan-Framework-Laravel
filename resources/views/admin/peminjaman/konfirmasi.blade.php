@extends('admin.layout.appadmin')

@section('content')
<div class="container">
    <h1>Konfirmasi Peminjaman</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
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


                        <!-- Button to trigger modal for rejection -->
                        <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal" data-id="{{ $item->id }}">Tolak</button> -->
                        <a href="{{ route('pinjaman.tolak.alasan', $item->id) }}" class="btn btn-danger">Tolak</a>

                    
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
                @foreach ($pinjaman as $item)
                <div class="modal-body">
                    <div class="form-group">
                        <label for="viewName">Nama</label>
                        <input type="text" class="form-control" id="viewName" name="viewName" value="{{$item->nama}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewName">Alamat</label>
                        <input type="text" class="form-control" id="viewName" name="viewName" value="{{$item->alamatt}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewName">Nomer Telepon</label>
                        <input type="text" class="form-control" id="viewName" name="viewName" value="{{$item->tlp}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewName">Keperluan</label>
                        <textarea type="text" class="form-control" id="viewName" name="viewName"  readonly>{{$item->keperluan}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="viewName">Nominal</label>
                        <input type="text" class="form-control" id="viewName" name="viewName" value="{{$item->nominal}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewName">Tanggal Peminjaman</label>
                        <input type="text" class="form-control" id="viewName" name="viewName" value="{{$item->tgl_pinjaman}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewName">Tanggal Pengembalian</label>
                        <input type="text" class="form-control" id="viewName" name="viewName" value="{{$item->tgl_pengembalian}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewName">Bunga</label>
                        <input type="text" class="form-control" id="viewName" name="viewName" value="{{$item->bunga}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewName">Total</label>
                        <input type="text" class="form-control" id="viewName" name="viewName" value="{{$item->total}}" readonly>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



@endsection
