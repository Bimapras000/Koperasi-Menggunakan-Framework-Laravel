@if($riwayat->isEmpty())
    <p>Belum ada riwayat tabungan.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Jenis Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1 @endphp
            @foreach($riwayat as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>Rp {{ number_format($item->nominal, 2) }}</td>
                    <td>{{ $item->jenis_transaksi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
