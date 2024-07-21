@extends('user.layouts.appadmin')
@section('content')


<div class="container-fluid">
    <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c1">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                            <img src="{{asset('admin/images/icon/user.png')}}" alt="Jumlah Anggota" />
                        </div>
                        <div class="text">
                            <h2>{{ Auth::user()->name }}</h2>
                            <span>Nama Anggota</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c2">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                            <img src="{{asset('admin/images/icon/rp.png')}}" alt="Uang Dipinjam" />
                        </div>
                        <div class="text">
                            <h2>{{ number_format($jumlahPeminjaman, 2) }}</h2>
                            <span>Uang Dipinjam</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c3">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                            <img src="{{asset('admin/images/icon/rp.png')}}" alt="Setoran Mingguan" />
                        </div>
                        <div class="text">
                            <h2>{{ number_format($setoranMingguIni, 2) }}</h2>
                            <span>Setoran Mingguan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c4">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                            <img src="{{asset('admin/images/icon/rp.png')}}" alt="Total Tabungan" />
                        </div>
                        <div class="text">
                            <h2>{{ number_format($totalTabungan, 2) }}</h2>
                            <span>Total Tabungan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            <h2 class="title-1 m-b-25">Riwayat Setoran</h2>
            <div class="table-responsive table--no-card m-b-40" style="max-height: 350px; overflow-y: auto;">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th class="text-right">Nominal</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksiSetoranTerakhir as $transaksi)
                            <tr>
                                <td>{{ $transaksi->tgl_setor }}</td>
                                <td>{{ $transaksi->users->name }}</td>
                                <td class="text-right">Rp. {{ number_format($transaksi->nominal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <a href="{{url('/user/setoruser')}}" class="au-btn au-btn-load">Lihat Lebih</a>
            </div>
        </div>
    </div>
</div>




@endsection