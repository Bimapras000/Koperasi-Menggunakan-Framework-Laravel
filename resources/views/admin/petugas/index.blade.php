@extends('admin.layout.appadmin')
@section('content')

<!-- <div class="section__content section__content--p30"> -->
                    <!-- <div class="container-fluid"> -->
<div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">Data Petugas</h3>
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
											Tambah Petugas
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
                                                <th>Username</th>
                                                <th>Nomer Telepon</th>
                                                <th>alamat</th>      
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1 @endphp
                                        @foreach ($user as $user)
                                        @if($user->jabatan === 'petugas' || $user->jabatan === 'admin')
                                        
                                            <tr class="tr-shadow">
                                                
                                                <td>{{$no++}}</td>
                                                
                                                <td>
                                                    <span class="block-email">{{$user->name}}</span>
                                                </td>
                                                <td class="desc">{{$user->username}}</td>
                                                <td>{{$user->no_tlp}}</td>
                                                <td>
                                                    <span class="status--process">{{$user->alamat}}</span>
                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        
                                                        <a href="{{url('admin/anggota/edit/'.$user->id)}}" type="button" class="btn item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </a>

                                                        <button type="button" class="item" data-placement="top" title="Delete" data-toggle="modal" data-target="#deleteModal{{$user->id}}">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    
                                                        <button type="button" class="item" data-toggle="modal" data-target="#viewMemberModal" onclick="viewMemberDetails({{ $user->id }})" data-placement="top" title="View">
                                                            <i class="zmdi zmdi-eye"></i>
                                                        </button>

                                                    </div>

                                                    <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{$user->id}}">Hapus Data</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus data {{$user->name}}?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <a href="{{ url('admin/petugas/delete/'.$user->id) }}" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                </td>
                                            </tr>
                                            <tr class="spacer"></tr>
                                            
                                            @endif
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
                                    <form action="{{url('admin/petugas/store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="smallmodalLabel">Form Tambah Petugas</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required>
                                            @error('username')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="no_tlp">Nomer Telepon</label>
                                            
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+62</span>
                                                </div>
                                                <input type="text" class="form-control @error('no_tlp') is-invalid @enderror" id="no_tlp" name="no_tlp" required>
                                            </div>
                                            @error('no_tlp')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required>
                                            <span>Format : Desa, RT RW </span>
                                            @error('alamat')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="ktp">Foto Ktp</label>
                                            <input type="file" id="ktp" name="ktp" class="form-control-file @error('ktp') is-invalid @enderror" >
                                            @error('foto')
                                                <div class="invalid-feedback">
                                                    {{$message}}
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
                <h5 class="modal-title" id="viewMemberModalLabel">Detail Petugas</h5>
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