<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Setoran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        .header .details {
            text-align: center;
        }

        .header .details h1 {
            margin: 0;
            font-size: 24px;
        }

        .header .details p {
            margin: 5px 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    
</head>
<body>
@php
        use Carbon\Carbon;
    @endphp
    <div class="header">
        <br>
        <div class="details">
            <h1>Koperasi Mayangsari</h1>
            <p>Jl. Abadi, Kemloko, Kec. Nglegok, Kabupaten Blitar</p>
        </div>
    </div><hr>
    <h1>Riwayat Setoran</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Nominal</th>
                <th>Jenis Setor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($setor as $setors)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $setors->tgl_setor }}</td>
                    <td>{{ $setors->users->name }}</td>
                    <td>{{ number_format($setors->nominal, 0, ',', '.') }}</td>
                    <td>{{ $setors->jenis_setor }}</td>
                    <td>
                        @if($setors->konfirmasi == \App\Models\Setor::STATUS_APPROVED)
                            Dikonfirmasi
                        @elseif($setors->konfirmasi == \App\Models\Setor::STATUS_REJECTED)
                            Ditolak
                        @else
                            Pending
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total Setoran yang Dikonfirmasi per Bulan</h2>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($confirmedSetorPerMonth as $setoran)
                <tr>
                    <td>{{ Carbon::createFromDate($setoran->year, $setoran->month, 1)->format('F Y') }}</td>
                    <td>{{ number_format($setoran->total_nominal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
