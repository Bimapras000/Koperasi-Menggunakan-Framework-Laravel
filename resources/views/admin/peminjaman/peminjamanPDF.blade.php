<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman</title>
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
    <div class="header">
        <br>
        <div class="details">
            <h1>Koperasi Mayangsari</h1>
            <p>Jl. Abadi, Kemloko, Kec. Nglegok, Kabupaten Blitar</p>
        </div>
    </div>
    <hr>
    <h1>Data Peminjaman</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Nominal</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($peminjaman as $pinjam)
                <tr>
                    <td>{{ $no++ }}</td>
                    
                    <td>{{ $pinjam->users->name }}</td>
                    <td>{{ $pinjam->tgl_pinjaman}}</td>
                    <td>{{ $pinjam->tgl_pengembalian }}</td>
                    <td>{{ number_format($pinjam->nominal, 0, ',', '.') }}</td>
                    <td>{{ number_format($pinjam->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="{{ $pinjam->status == 'Lunas' ? 'status-lunas' : 'status-belum-lunas' }}">
                            {{ $pinjam->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
