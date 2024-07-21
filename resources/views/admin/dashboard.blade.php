@extends('admin.layout.appadmin')
@section('content')

<!-- <div class="section__content section__content--p30"> -->
<div class="container-fluid">
    <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c1">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        <img src="{{asset('admin/images/icon/user.png')}}" alt="CoolAdmin"  />
                        </div>
                        <div class="text">
                            <h2>{{ $jumlahAnggota }}</h2>
                            <span>Jumlah Anggota</span>
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
                            <img src="{{asset('admin/images/icon/rp.png')}}" alt="CoolAdmin"  />  
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
                        <img src="{{asset('admin/images/icon/rp.png')}}" alt="CoolAdmin"  />
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
                        <img src="{{asset('admin/images/icon/rp.png')}}" alt="CoolAdmin"  />
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
                            <th class="text-right">Nominal</th>                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksiSetoranTerakhir as $transaksi)
                            <tr>
                                <td>{{ $transaksi->tgl_setor }}</td>
                                <td>{{ $transaksi->user_name }}</td>
                                <td class="text-right">Rp. {{ number_format($transaksi->nominal, 2) }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <a href="{{url('/admin/setor')}}" class="au-btn au-btn-load ">Lihat Lebih</a>
            </div>
        </div>
    </div>
</div><br><br><br>

<div class="row">
    <div class="col-lg-6">
        <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
            <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                <div class="bg-overlay bg-overlay--blue"></div>
                <h3>
                    <i class="zmdi zmdi-account-calendar"></i>Konfirmasi Setoran
                </h3>
            </div>
            <div class="au-task js-list-load">
                <div class="au-task__title">
                </div>
                <div class="au-task-list js-scrollbar3">
                    @foreach ($setoranBelumDikonfirmasi as $setoran)
                    <div class="au-task__item au-task__item--primary">
                        <div class="au-task__item-inner">
                            <h5 class="task">
                                <a href="#">{{ $setoran->users->name }} melakukan setoran perlu konfirmasi</a>
                            </h5>
                            <span class="time">{{ $setoran->tgl_setor }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="au-task__footer">
                    <a href="{{url('/admin/konfirmasi')}}" class="au-btn au-btn-load ">Lihat Lebih</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
            <div class="au-card-title" style="background-image:url('images/bg-title-02.jpg');">
                <div class="bg-overlay bg-overlay--blue"></div>
                <h3>
                    <i class="zmdi zmdi-comment-text"></i>Konfirmasi Pinjaman
                </h3>
            </div>
            <div class="au-inbox-wrap js-inbox-wrap">
                <div class="au-message js-list-load">
                    <div class="au-message__noti">
                    </div>
                    <div class="au-message-list">
                        @foreach ($pinjamanBelumDikonfirmasi as $pinjaman)
                        <div class="au-message__item unread">
                            <div class="au-message__item-inner">
                                
                                    
                                    <div class="text">
                                        <h5 class="name">{{ $pinjaman->users->name }}</h5>
                                        <p>Jumlah Pinjaman : {{ $pinjaman->total }}</p>
                                        <span>{{ $pinjaman->tgl_pinjaman }} - {{$pinjaman->tgl_pengembalian}}</span>
                                    </div>
                                    
                                <div class="au-message__item-time">
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="au-message__footer">
                        <a href="{{ route('pinjaman.konfirmasiIndex') }}" class="au-btn au-btn-load ">Lihat Lebih</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- </div> -->
                                
                        
@endsection