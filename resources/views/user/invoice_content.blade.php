<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
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
        .kop h1, .kop h2 {
            margin: 0;
        }
        .kop h1 {
            font-size: 24px;
        }
        .kop h2 {
            font-size: 20px;
        }
        .content {
            margin-top: 50px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tfoot td {
            font-weight: bold;
        }
        .details-table {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
            border: none;
        }
        .details-table td {
            padding: 5px 10px;
            border: none;
        }
        .details-table .label {
            width: 20%;
            font-weight: bold;
            border: none;s
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- <img src="{{ asset('images/logo.png') }}" alt="Logo Koperasi"> -->
        <div class="details">
            <h1>Koperasi Mayangsari</h1>
            <p>Jl. Abadi, Kemloko, Kec. Nglegok, Kabupaten Blitar</p>
        </div>
    </div><hr>
    <div class="content">
        <h3>Invoice</h3><br>
        <table class="details-table">
            <tr>
                <td class="label">Invoice Code:</td>
                <td>{{ $invoiceCode }}</td>
            
                <td class="label">Alamat:</td>
                <td>{{ $setor->alamat }}</td>
                
                
            </tr>
            <tr>
                <td class="label">Nama:</td>
                <td>{{ $setor->nama }}</td>
                <td class="label">Telepon:</td>
                <td>{{ $setor->no_tlp }}</td>
            </tr>
            
        </table><br><br>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jenis Setoran</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $setor->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($setor->tgl_setor)->format('d-m-Y') }}</td>
                    <td>{{$setor->jenis_setor}}</td>
                    <td>Rp {{ number_format($setor->nominal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total</td>
                    <td>Rp {{ number_format($setor->nominal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer">
        <p>Terima kasih telah melakukan transaksi dengan koperasi kami.</p>
    </div>
</body>
</html>
