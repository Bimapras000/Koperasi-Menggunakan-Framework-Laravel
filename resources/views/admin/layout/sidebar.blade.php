<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="{{asset('admin/css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{asset('admin/vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{asset('admin/vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('admin/vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <!-- <link href="{{asset('admin/vendor/select2/select2.min.css')}}" rel="stylesheet" media="all"> -->
    <link href="{{asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Main CSS-->
    <link href="{{asset('admin/css/theme.css')}}" rel="stylesheet" media="all">
    <style>
    .status-lunas {
        background-color: green;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        display: inline-block;
    }

    .status-belum-lunas {
        background-color: red;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        display: inline-block;
    }
    /* Mengatur ukuran logo di header mobile */
    .header-mobile .logo img {
            width: 100%;
            max-width: 120px; /* Atur lebar maksimum untuk logo */
            height: auto;
        }

        /* Media query untuk layar kecil */
        @media (max-width: 768px) {
            .header-mobile .logo img {
                max-width: 120px; /* Atur lebar maksimum untuk layar kecil */
            }
        }

        /* Gaya untuk hamburger menu */
        .hamburger {
            display: inline-block;
            cursor: pointer;
        }

        .hamburger-box {
            width: 24px;
            height: 24px;
            display: inline-block;
            position: relative;
        }

        .hamburger-inner {
            display: block;
            top: 50%;
            margin-top: -2px;
            background-color: #000;
            width: 24px;
            height: 2px;
            border-radius: 2px;
            position: absolute;
            transition: all 0.4s ease;
        }

        .hamburger-inner:before,
        .hamburger-inner:after {
            content: "";
            display: block;
            background-color: #000;
            width: 24px;
            height: 2px;
            border-radius: 2px;
            position: absolute;
            transition: all 0.4s ease;
        }

        .hamburger-inner:before {
            top: -8px;
        }

        .hamburger-inner:after {
            bottom: -8px;
        }
</style>



</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="{{asset('admin/images/icon/logo3.png')}}" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                    <li class="active has-sub">
                            <a class="js-arrow" href="{{url('/admin/dashboard')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{url('/admin/tabungan')}}">
                                <i class="fas fa-chart-bar"></i>Tabungan</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/anggota') }}">
                                <i class="fas fa-table"></i>Anggota</a>
                        </li>
                        <li>
                        @if (Auth::user()->jabatan == 'admin')
                            <a href="{{url('/admin/petugas')}}">
                                <i class="fas fa-table"></i>Petugas</a>
                        @endif
                        </li>
                        <li>
                            <a href="{{url('/admin/setor')}}">
                                <i class="fa fa-dollar"></i>Setor</a>
                        </li>
                        <li>
                            <a href="{{url('/admin/konfirmasi')}}">
                                <i class="fa fa-check-square"></i>Konfirmasi Setoran</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="far fa-check-square"></i>Pinjaman</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="{{url('/admin/peminjaman')}}">Pinjaman</a>
                                </li>
                                <li>
                                    <a href="{{ route('pinjaman.konfirmasiIndex') }}">Konfirmasi Pinjaman</a>
                                </li>
                                <li>
                                    <a href="{{url('/admin/riwayat')}}">Riwayat Pinjaman</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a  href="{{ route('index.pdf') }}">
                                <i class="fas fa-copy"></i>Eksport</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="{{asset('admin/images/icon/logo3.png')}}" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="{{url('/admin/dashboard')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{url('/admin/tabungan')}}">
                                <i class="fas fa-chart-bar"></i>Tabungan</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/anggota') }}">
                                <i class="fas fa-table"></i>Anggota</a>
                        </li>
                        <li>
                        @if (Auth::user()->jabatan == 'admin')
                            <a href="{{url('/admin/petugas')}}">
                                <i class="fas fa-table"></i>Petugas</a>
                        @endif
                        </li>
                        <li>
                            <a href="{{url('/admin/setor')}}">
                                <i class="fa fa-dollar"></i>Setor</a>
                        </li>
                        <li>
                            <a href="{{url('/admin/konfirmasi')}}">
                                <i class="fa fa-check-square"></i>Konfirmasi Setoran</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="far fa-check-square"></i>Pinjaman</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="{{url('/admin/peminjaman')}}">Pinjaman</a>
                                </li>
                                <li>
                                    <a href="{{ route('pinjaman.konfirmasiIndex') }}">Konfirmasi Pinjaman</a>
                                </li>
                                <li>
                                    <a href="{{url('/admin/riwayat')}}">Riwayat Pinjaman</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a  href="{{ route('index.pdf') }}">
                                <i class="fas fa-copy"></i>Eksport</a>
                        </li>
                        
                    </ul>
                </nav>
            </div>
        </aside>