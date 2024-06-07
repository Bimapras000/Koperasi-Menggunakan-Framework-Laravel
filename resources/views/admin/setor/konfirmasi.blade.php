@extends('admin.layout.appadmin')

@section('content')
<div class="container">
    <h1>Konfirmasi Setoran</h1>

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
                <th>Nominal</th>
                <th class="text-right">Jumlah Setor</th>
                <th class="text-right">Jenis Setor</th>
                <th class="text-right">Tanggal</th>
                <th class="text-right">Bukti Setoran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
             @php $no = 1 @endphp
            @foreach ($setorans as $setoran)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $setoran->users->name }}</td>
                    <td>{{ $setoran->nominal }}</td>
                    <td>{{ $setoran->jlm_setor }}</td>
                    <td>{{ $setoran->jenis_setor }}</td>
                    <td>{{ $setoran->tgl_setor }}</td>
                    <td>
                        @if($setoran->bukti_foto)
                            <img src="{{ url('storage/fotos_bukti/' . $setoran->bukti_foto) }}" alt="Bukti Setor" width="100" class="bukti-foto" style="cursor: pointer;">
                        @else
                            Tidak ada bukti
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('setor.konfirmasi', $setoran->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Konfirmasi</button>
                        </form>

                        <form action="{{ route('setor.tolak' , $setoran->id) }}" method="POST" style="display:inline-block;">
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
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Setoran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Bukti Setoran" class="img-fluid">
            </div>
        </div>
    </div>
</div>

@endsection
