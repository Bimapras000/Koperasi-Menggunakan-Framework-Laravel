@extends('user.layouts.appadmin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="title-5 m-b-35">Data Tabungan</h3>
        <!-- <div class="table-data__tool">
            <div class="table-data__tool-left">
                <form class="form-header" action="" method="POST">
                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for data &amp; reports..." />
                    <button class="au-btn--submit green-button" type="submit">
                        <i class="zmdi zmdi-search "></i>
                    </button>
                </form>
            </div>
        </div> -->
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Saldo</th>
                        <!-- <th>Tarik</th> -->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1 @endphp
                    @foreach ($tabungan as $tabunga)
                        <tr class="tr-shadow">
                            <td>{{$no++}}</td>
                            <td><span class="block-email">{{Auth::user()->name}}</span></td>
                            <td>Rp {{ number_format($tabunga->saldo, 2) }}</td>
                            <!-- <td>
                                <label class="switch">
                                    <input type="checkbox" class="toggle-tarik" data-id="{{$tabunga->id}}" {{ $tabunga->tarik_enabled ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td> -->
                            <td>
                                <div class="table-data-feature">
                                    <button type="button" class="item" data-toggle="modal" data-target="#viewMemberModal" onclick="viewMemberDetails({{ $tabunga->id }})" data-placement="top" title="View">
                                        <i class="zmdi zmdi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Riwayat Tabungan -->
<div class="modal fade" id="viewMemberModal" tabindex="-1" role="dialog" aria-labelledby="viewMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMemberModalLabel">Riwayat Tabungan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="riwayatTabunganContent">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1 @endphp
                            @foreach($riwayat as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->tgl_setor }}</td>
                                    <td>Rp {{ number_format($item->nominal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script>
    function viewMemberDetails(tabunganId) {
        $.ajax({
            url: '{{ route('anggota.riwayat.tabungan') }}',
            method: 'GET',
            data: { id: tabunganId },
            success: function(response) {
                $('#riwayatTabunganContent').html(response);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
@endsection


@endsection