@extends('user.layouts.appadmin')
@section('content')


<div class="row">
    <div class="col-md-12">
        <h3 class="title-5 m-b-35">Riwayat Setoran</h3>
        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <form class="form-header" action="{{ route('anggota.setor') }}" method="GET">
                    <input class="au-input au-input--xl search-field" type="text" name="name" id="name" placeholder="Search for datas &amp; reports..." />
                    <button class="au-btn--submit" type="submit">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </form>
            </div>
            <div class="table-data__tool-right">
                <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#smallmodal">
                    <i class="zmdi zmdi-plus"></i> Tambah Setoran
                </button>
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
                @php $no = ($setor->currentPage() - 1) * $setor->perPage() + 1; @endphp
                @foreach ($setor as $setors)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$setors->tgl_setor}}</td>
                        <td>{{ Auth::user()->name }}</td>
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
        {{ $setor->links('pagination::bootstrap-5') }}
    </div>
</div>

<div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{ route('anggota.setor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Form Tambah Setoran</h5>
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
                        <label for="nominal">Nominal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" min="50000" required>
                        </div>
                        @error('nominal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
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
                        <label for="total_nominal">Total Nominal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" class="form-control" id="total_nominal" name="total_nominal" readonly>
                        </div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('nominal').addEventListener('input', calculateTotal);
    document.getElementById('jlm_setor').addEventListener('input', calculateTotal);

    function calculateTotal() {
        var nominal = document.getElementById('nominal').value;
        var jlm_setor = document.getElementById('jlm_setor').value;
        var total = nominal * jlm_setor;
        document.getElementById('total_nominal').value = total;
    }
</script>



@endsection