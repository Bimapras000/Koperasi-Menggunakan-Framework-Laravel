@extends('user.layouts.appadmin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="title-5 m-b-35">Peminjaman</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <form class="form-header" action="" method="POST">
                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                    <button class="au-btn--submit" type="submit">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </form>
            </div>
            <div class="table-data__tool-right">
                <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#smallmodal"><i class="zmdi zmdi-plus"></i> Tambah Peminjaman</button>

                <div class="rs-select2--dark rs-select2--sm rs-select2--dark2 dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cetak</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('Peminjaman.pdf') }}">PDF</a>
                        <a class="dropdown-item" href="{{ route('Peminjaman.excel') }}">Excel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive table--no-card m-b-40" style="max-height: 560px; overflow-y: auto;">
            <table class="table table-borderless table-striped table-earning">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal Pinjaman</th>
                        <th>Tanggal Kembali</th>
                        <th>Nominal</th>
                        <th>Bunga</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                @php $no = 1 @endphp
                @foreach ($peminjaman as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->tgl_pinjaman }}</td>
                        <td>{{ $item->tgl_pengembalian }}</td>
                        <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td>{{ $item->bunga }}</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="{{ $item->status == 'Lunas' ? 'status-lunas' : 'status-belum-lunas' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ url('admin/peminjaman/'.$item->id) }}" class="btn btn-info">Detail</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $peminjaman->links('pagination::bootstrap-5') }}
    </div>
</div>

<div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{ url('admin/peminjaman/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Form Tambah Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal-body">
                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <textarea type="text" class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan" required></textarea>
                        @error('keperluan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" step="0.01" required>
                        @error('nominal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_pinjaman">Tanggal Peminjaman</label>
                        <input type="date" class="form-control @error('tgl_pinjaman') is-invalid @enderror" id="tgl_pinjaman" name="tgl_pinjaman" required>
                        @error('tgl_pinjaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_pengembalian">Tanggal Pengembalian</label>
                        <input type="date" class="form-control @error('tgl_pengembalian') is-invalid @enderror" id="tgl_pengembalian" name="tgl_pengembalian" required>
                        @error('tgl_pengembalian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bunga">Bunga (%)</label>
                        <input type="number" class="form-control @error('bunga') is-invalid @enderror" id="bunga" name="bunga" step="0.01" placeholder="2 %" readonly>
                        @error('bunga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="text" class="form-control @error('total') is-invalid @enderror" id="total" name="total" step="0.01" readonly>
                        @error('total')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection
