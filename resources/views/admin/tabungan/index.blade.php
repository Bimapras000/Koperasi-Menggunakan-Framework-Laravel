@extends('admin.layout.appadmin')
@section('content')

<!-- <div class="section__content section__content--p30"> -->
                    <!-- <div class="container-fluid"> -->

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
<div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">Data Tabungan</h3>
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left">
                                        <form class="form-header" action="{{ route('tabungan.index') }}" method="GET">
                                            <input class="au-input au-input--xl" type="text" name="search" placeholder=" " value="{{ old('search', $search) }}" />
                                            <button class="au-btn--submit" type="submit">
                                                <i class="zmdi zmdi-search"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="table-data__tool-right">
                                        <!-- <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>Tambah anggota</button> -->
                                            <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#smallmodal"><i class="zmdi zmdi-plus"></i>
											Tambah Tabungan
										    </button>

                                            <div class="rs-select2--dark rs-select2--sm rs-select2--dark2 dropdown">
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Cetak
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="{{ route('tabungan.pdf') }}">PDF</a>
                                                    <a class="dropdown-item" href="{{ route('tabungan.excel') }}">Excel</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive table-responsive-data2">
                                    <table class="table table-data2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Saldo</th>
                                                
                                                <th></th>
                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php 
                                        $no = ($tabungan->currentPage() - 1) * $tabungan->perPage() + 1;
                                        @endphp
                                        @foreach ($tabungan as $tabunga)
                                       
                                        
                                            <tr class="tr-shadow">
                                                
                                            <td>{{$no++}}</td>
                                            <td><span class="block-email">{{$tabunga->nama}}</span></td>
                                            <td>Rp {{ number_format($tabunga->saldo, 0, ',', '.') }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <button type="button" class="btn item" data-toggle="modal" data-target="#cicilanModal{{$tabunga->id}}" data-placement="top" title="Cicilan">
                                                        <i class="zmdi zmdi-money"></i>
                                                    </button>
                                                    <button type="button" class="btn item" data-toggle="modal" data-target="#editModal{{$tabunga->id}}" data-placement="top" title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <button type="button" class="item" data-placement="top" title="Delete" data-toggle="modal" data-target="#deleteModal{{$tabunga->id}}">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </div>
                                                <div class="modal fade" id="deleteModal{{$tabunga->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{$tabunga->id}}">Hapus Data</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah anda yakin ingin menghapus data {{$tabunga->nama}}?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                                                <a href="{{ url('admin/tabungan/delete/'.$tabunga->id) }}" class="btn btn-danger">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            </tr>
                                            <tr class="spacer"></tr>
                                            <!-- Modal Cicilan -->
                                            <div class="modal fade" id="cicilanModal{{$tabunga->id}}" tabindex="-1" role="dialog" aria-labelledby="cicilanModalLabel{{$tabunga->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cicilanModalLabel{{$tabunga->id}}">Bayar Cicilan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tabungan.cicilan', $tabunga->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nominal{{$tabunga->id}}">Nominal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" name="nominal" id="nominal{{$tabunga->id}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="komentar{{$tabunga->id}}">Komentar</label>
                        <textarea name="komentar" id="komentar{{$tabunga->id}}" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Bayar Cicilan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var cleaveC = new Cleave('#nominal{{$tabunga->id}}', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        delimiter: '.',
        numeralDecimalMark: ','
    });
});
</script>

                                            <!-- Modal Edit Tabungan -->
<div class="modal fade" id="editModal{{$tabunga->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$tabunga->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$tabunga->id}}">Edit Tabungan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tabungan.update', $tabunga->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama{{$tabunga->id}}">Nama</label>
                        <input type="text" name="nama" id="nama{{$tabunga->id}}" class="form-control" value="{{ $tabunga->nama }}" required>
                    </div>
                    <div class="form-group">
                        <label for="saldo{{$tabunga->id}}">Saldo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                        <input type="number" name="saldo" id="saldo{{$tabunga->id}}" class="form-control" value="{{ number_format($tabunga->saldo, 0, ',', '.') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
                                            
                                            @endforeach
                                            
                                        </tbody>

                                        
                                    </table>
                                </div>
                                {{ $tabungan->links('pagination::bootstrap-5') }}
                                
    

                                <!-- END DATA TABLE -->
                            </div>
                        </div>
                        <!-- </div> -->
<!-- </div> -->
                        <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <form action="{{url('admin/tabungan/store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="smallmodalLabel">Form Tambah Tabungan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <select name="users_id" id="select" class="form-control @error('users_id') is-invalid @enderror">
                            @foreach ($users as $user)
                                @if ($user->jabatan == 'anggota' || $user->jabatan == 'petugas')
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('users_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="saldo">Saldo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control @error('saldo') is-invalid @enderror" id="nominal" name="saldo" value="{{ old('saldo') }}" required>
                        </div>
                        @error('saldo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

<script>
    $(document).ready(function() {
        // Menutup modal setelah submit form
        $('form').on('submit', function() {
            $('.modal').modal('hide');
        });
    });
</script>



@endsection