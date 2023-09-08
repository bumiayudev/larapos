@extends('layouts.default')

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-header">Form tambah data pengguna baru</div>
        <div class="card-body">
            <form action="">
                <div class="form-group">
                    <label for="">Kode Pengguna</label>
                    <input type="text" name="kd_petugas" id="kd_petugas" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Nama Pengguna</label>
                    <input type="text" name="nm_ptg" id="nm_ptg" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email Pengguna</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Simpan</button>
                <a href="{{ route('users') }}" class="btn btn-warning"><i class="fas fa-undo-alt"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection