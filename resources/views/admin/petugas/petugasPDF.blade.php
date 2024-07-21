<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
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
    <h3 align="center">Data Petugas</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Nomer Telepon</th>
                <th>alamat</th>     
                <th>KTP</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1 @endphp
            @foreach ($petugas as $a)
                                    
            <tr>
                <td>{{$no++}}</td>
                <td>{{$a->name}}</td>
                <td>{{$a->username}}</td>
                <td>{{$a->no_tlp}}</td>
                <td>{{$a->alamat}}</td>
                <td>{{$a->KTP}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
