@extends('admin.layout.appadmin')
@section('content')

<!-- <div class="section__content section__content--p30"> -->
                    <!-- <div class="container-fluid"> -->
<div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">Riwayat Peminjaman</h3>
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left">
                                        <form class="form-header" action="" method="POST">
                                            <input class="au-input au-input--xl" type="text" name="search" placeholder="" />
                                            <button class="au-btn--submit" type="submit">
                                                <i class="zmdi zmdi-search"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="table-data__tool-right">
                                        <!-- <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>Tambah anggota</button> -->
                                            <!-- <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#smallmodal"><i class="zmdi zmdi-plus"></i>
											Tambah Peminjaman
										    </button> -->

                                            
                                    </div>
                                </div>
                                <div class="table-responsive table--no-card m-b-40" style="max-height: 580px; overflow-y: auto;">
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
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        
                                    </table>
                                </div>
                                {{ $pinjaman->links('pagination::bootstrap-5') }}
                                
    

                                <!-- END DATA TABLE -->
                            </div>
                        </div>
                        @endsection