@extends('admin.layout.appadmin')
@section('content')

<!-- <div class="section__content section__content--p30"> -->
                    <!-- <div class="container-fluid"> -->
<div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">Riwayat Setoran</h3>
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
											Tambah Setoran
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
                                <div class="table-responsive table--no-card m-b-40" style="max-height: 450px; overflow-y: auto;">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama</th>
                                                <th class="text-right">Jumlah Setor</th>
                                                <th class="text-right">Nominal</th>
                                                <th class="text-right">Jenis Setor</th>
                                                <th class="text-right">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1 @endphp
                                        @foreach ($setor as $setors)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$setors->tgl_setor}}</td>
                                                <td>{{$setors->nama}}</td>
                                                <td class="text-right">{{$setors->jlm_setor}}</td>
                                                <td class="text-right">{{$setors->nominal}}</td>
                                                <td class="text-right">{{$setors->jenis_setor}}</td>
                                                <td class="text-right">
                                                    @if($setors->konfirmasi == \App\Models\Setor::STATUS_APPROVED)
                                                        <span class="badge badge-success">Dikonfirmasi</span>
                                                    @elseif($setors->konfirmasi == \App\Models\Setor::STATUS_REJECTED)
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                
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
            <form action="{{ url('admin/setor/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Form Tambah Setoran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <select name=" users_id " id="users_id" class="form-control @error('name') is-invalid @enderror js-select2">
                            @foreach ($users as $user)
                                @if ($user->jabatan == 'anggota' || $user->jabatan == 'petugas')
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" required>
                        </div>
                        @error('nominal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jlm_setor">Jumlah Setor</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('jlm_setor') is-invalid @enderror" id="jlm_setor" name="jlm_setor" required>
                        </div>
                        @error('jlm_setor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_setor">Tanggal Setor</label>
                        <input type="date" class="form-control @error('tgl_setor') is-invalid @enderror" id="tgl_setor" name="tgl_setor" required>
                        @error('tgl_setor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_setor">Jenis Setoran</label>
                        <select name="jenis_setor" id="jenis_setor" class="form-control @error('jenis_setor') is-invalid @enderror">
                            <option value="Menabung">Menabung</option>
                            <option value="Cicilan">Cicilan</option>
                        </select>
                        @error('jenis_setor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bukti_foto">Bukti Foto Setoran</label>
                        <input type="file" id="bukti_foto" name="bukti_foto" class="form-control-file @error('bukti_foto') is-invalid @enderror">
                        @error('bukti_foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
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

