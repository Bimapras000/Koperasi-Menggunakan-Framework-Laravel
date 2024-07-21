@extends('admin.layout.appadmin')
@section('content')


<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif

@foreach ($user as $user)
<div class="card shadow mb-4">
    <div class="card-body">
<form method="POST" action="{{url('admin/petugas/update/'.$user->id)}}" enctype="multipart/form-data">
  @csrf
  <div class="form-group row">
    <label for="text" class="col-4 col-form-label">Nama</label> 
    <div class="col-8">
      <input id="text" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{$user->name}}">
      @error('name')
        <div class="invalid-feedback">
            {{$message}}
        </div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label for="text" class="col-4 col-form-label">Username</label> 
    <div class="col-8">
      <input id="text" name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{$user->username}}">
      @error('username')
        <div class="invalid-feedback">
            {{$message}}
        </div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label for="text1" class="col-4 col-form-label">Alamat</label> 
    <div class="col-8">
      <input id="text1" name="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" value="{{$user->alamat}}">
      @error('alamat')
        <div class="invalid-feedback">
            {{$message}}
        </div>
      @enderror
    </div>
  </div>
  
  <div class="form-group row">
    <label for="text2" class="col-4 col-form-label">Nomor Telepon</label> 
    <div class="col-8">
      <input id="text2" name="no_tlp" type="text" class="form-control @error('no_tlp') is-invalid @enderror" value="{{$user->no_tlp}}">
      @error('no_tlp')
        <div class="invalid-feedback">
            {{$message}}
        </div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label for="text2" class="col-4 col-form-label">Jabatan</label> 
    <div class="col-8">
    <select id="select" name="jabatan" class="custom-select">
      @foreach($jabatans as $jabatan)
        <option value="{{$jabatan}}" @if($user->jabatan === $jabatan) selected @endif>{{$jabatan}}</option>
      @endforeach
      </select>
    </div>
  </div>
  
  <div class="form-group row">
    <label for="text4" class="col-4 col-form-label">Password</label> 
    <div class="col-8">
      <input id="text4" name="password" type="text" class="form-control @error('password') is-invalid @enderror" value="{{$user->password}}">
      @error('password')
        <div class="invalid-feedback">
            {{$message}}
        </div>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label for="text4" class="col-4 col-form-label">Foto KTP</label> 
    <div class="col-8">
      <input id="text4" name="ktp" type="file" class="form-control @error('ktp') is-invalid @enderror" >
      @if (!empty($user->ktp) && !request()->hasFile('ktp'))
            <img src="{{ asset('storage/fotos/'.$user->ktp) }}" alt="Photo Profil">
        @endif
      @error('ktp')
        <div class="invalid-feedback">
            {{$message}}
        </div>
      @enderror
    </div>
  </div>
  
  <div class="form-group row">
    <div class="offset-4 col-8">
        <a href="{{url('admin/petugas')}}" class="btn btn-secondary">Batal</a>
      <button name="submit" type="submit" class="btn btn-warning" style="color:white">Edit</button>
    </div>
  </div>
</form>
</div>
</div>

@endforeach

@endsection