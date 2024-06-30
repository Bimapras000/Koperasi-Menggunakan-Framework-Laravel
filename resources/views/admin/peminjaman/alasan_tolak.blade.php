@extends('admin.layout.appadmin')
@section('content')
    <div class="container">
        <h1>Alasan Penolakan Peminjaman</h1>

        <form action="{{ route('pinjaman.tolak.process', $pinjaman->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="alasan">Alasan Penolakan</label>
                <textarea class="form-control" id="alasan" name="alasan" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Kirim Alasan</button>
        </form>
    </div>
@endsection
