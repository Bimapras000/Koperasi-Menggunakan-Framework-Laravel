@extends('admin.layout.appadmin')
@section('content')

<!-- <div class="section__content section__content--p30"> -->
                    <!-- <div class="container-fluid"> -->
<div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">Data Tabungan</h3>
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
                                        <!-- <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>Tambah anggota</button> -->
                                            <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#smallmodal"><i class="zmdi zmdi-plus"></i>
											Tambah Tabungan
										    </button>

                                            <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                            <select class="js-select2" name="type">
                                                <option selected="selected">Export</option>
                                                <option value="">Option 1</option>
                                                <option value="">Option 2</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
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
                                                <th>Tarik</th>
                                                <th></th>
                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1 @endphp
                                        @foreach ($tabungan as $tabunga)
                                       
                                        
                                            <tr class="tr-shadow">
                                                
                                            <td>{{$no++}}</td>
                    <td><span class="block-email">{{$tabunga->nama}}</span></td>
                    <td>Rp {{ $tabunga->saldo }}</td>
                    <td>
                    <!-- Button to open the modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tarikModal{{$tabunga->id}}">
                        Tarik
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="tarikModal{{$tabunga->id}}" tabindex="-1" role="dialog" aria-labelledby="tarikModalLabel{{$tabunga->id}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tarikModalLabel{{$tabunga->id}}">Tarik Saldo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ url('admin/tabungan/tarik', $tabunga->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="amount">Jumlah Saldo yang Ditarik</label>
                                            <input type="number" name="amount" class="form-control" placeholder="Masukkan jumlah" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Tarik</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
                    <td>
                        <div class="table-data-feature">
                            <a href="{{url('admin/anggota/edit/'.$tabunga->id)}}" type="button" class="btn item" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            <button type="button" class="item" data-placement="top" title="Delete" data-toggle="modal" data-target="#deleteModal{{$tabunga->id}}">
                                <i class="zmdi zmdi-delete"></i>
                            </button>
                            <button type="button" class="item" data-toggle="modal" data-target="#viewMemberModal" onclick="viewMemberDetails({{ $tabunga->id }})" data-placement="top" title="View">
                                <i class="zmdi zmdi-eye"></i>
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{ url('admin/anggota/delete/'.$tabunga->id) }}" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                                            </tr>
                                            <tr class="spacer"></tr>
                                            
                                            
                                            @endforeach
                                            
                                        </tbody>

                                        
                                        


                                    </table>
                                </div>

                                
    

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
                            <input type="text" class="form-control @error('saldo') is-invalid @enderror" id="saldo" name="saldo" required>
                        </div>
                        @error('saldo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- modal view -->
                        <div class="modal fade" id="viewMemberModal" tabindex="-1" role="dialog" aria-labelledby="viewMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMemberModalLabel">Detail Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="viewName">Nama</label>
                    <input type="text" class="form-control" id="viewName" name="viewName" readonly>
                </div>
                <div class="form-group">
                    <label for="viewUsername">Username</label>
                    <input type="text" class="form-control" id="viewUsername" name="viewUsername" readonly>
                </div>
                <div class="form-group">
                    <label for="viewNoTlp">Nomer Telepon</label>
                    <input type="text" class="form-control" id="viewNoTlp" name="viewNoTlp" readonly>
                </div>
                <div class="form-group">
                    <label for="viewAlamat">Alamat</label>
                    <input type="text" class="form-control" id="viewAlamat" name="viewAlamat" readonly>
                </div>
                <div class="form-group">
                    <label for="viewJabatan">Jabatan</label>
                    <input type="text" class="form-control" id="viewJabatan" name="viewJabatan" readonly>
                </div>
                <div class="form-group">
                    <label for="viewKtp">Foto KTP</label><br>
                    <img id="viewKtp" class="img-fluid" src="" alt="Foto KTP">
                </div>
               >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@endsection