<!DOCTYPE html>
<html>
<head>
    <title>Data Tabungan</title>
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
    </div><hr>
    <h1>Data Tabungan</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>alamat</th>
                <th>Jumlah Tabungan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabungan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->users->name }}</td>
                    <td>{{ $item->users->alamat }}</td>
                    <td>{{ $item->saldo }}</td> <!-- Sesuaikan dengan field yang sesuai -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
