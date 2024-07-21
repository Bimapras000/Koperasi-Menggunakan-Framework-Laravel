@extends('user.layouts.appadmin')
@section('content')

<!-- <div class="section__content section__content--p30"> -->
                    <!-- <div class="container-fluid"> -->
<div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">Riwayat Peminjaman</h3>
                                <div class="table-data__tool">
                                    
                                    <div class="table-data__tool-right">
                                        <!-- <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>Tambah anggota</button> -->
                                            <!-- <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#smallmodal"><i class="zmdi zmdi-plus"></i>
											Tambah Peminjaman
										    </button> -->

                                            
                                    </div>
                                </div>
                                <div class="table-responsive table--no-card m-b-40" style="max-height: 450px; overflow-y: auto;">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                
                                                <th>Nama</th>
                                                <!-- <th>Keperluan</th> -->
                                                <th>Tanggal Pinjaman</th>
                                                <th>Tanggal Kembali</th>
                                                <th>Nominal</th>
                                                <!-- <th>Bunga</th> -->
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php $no = 1 @endphp
                                        @foreach ($pinjaman as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                
                                                <td>{{ $item->nama }}</td>
                                                <!-- <td>{{ $item->keperluan }}</td> -->
                                                <td>{{ $item->tgl_pinjaman }}</td>
                                                <td>{{ $item->tgl_pengembalian }}</td>
                                                <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <!-- <td>{{ $item->bunga }}</td> -->
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                                <td>
                                                    @if($item->konfirmasi == \App\Models\Setor::STATUS_APPROVED)
                                                        <span class="badge badge-success">Dikonfirmasi</span>
                                                    @elseif($item->konfirmasi == \App\Models\Setor::STATUS_REJECTED)
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailModal{{ $item->id }}">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Peminjaman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Keperluan:</strong> {{ $item->keperluan }}</p>
                                    <p><strong>Nominal:</strong> {{ $item->nominal }}</p>
                                    <p><strong>Tanggal Pinjaman:</strong> {{ $item->tgl_pinjaman }}</p>
                                    <p><strong>Tanggal Pengembalian:</strong> {{ $item->tgl_pengembalian }}</p>
                                    <p><strong>Total:</strong> {{ $item->total }}</p>
                                    <p><strong>Status:</strong>
                                        @if($item->konfirmasi == \App\Models\Setor::STATUS_APPROVED)
                                            Dikonfirmasi
                                        @elseif($item->konfirmasi == \App\Models\Setor::STATUS_REJECTED)
                                            Ditolak
                                        @else
                                            Pending
                                        @endif
                                    </p>
                                    @if($item->konfirmasi == \App\Models\Setor::STATUS_REJECTED)
                                        <p><strong>Alasan Penolakan:</strong> {{ $item->alasan }}</p>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $pinjaman->links('pagination::bootstrap-5') }}
    </div>
</div>
                        @endsection