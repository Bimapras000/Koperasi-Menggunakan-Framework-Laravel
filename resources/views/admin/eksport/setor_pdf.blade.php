<!DOCTYPE html>
<html>
<head>
    <title>Data Setor</title>
    <style>
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
    <h1>Data Setor</h1>
    <p>Rentang Tanggal: {{ $startDate }} - {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Setor</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->users->name }}</td>
                    <td>{{ $item->tgl_setor }}</td>
                    <td>{{ $item->nominal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
