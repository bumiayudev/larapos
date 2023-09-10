@extends('layouts.default')

@section('content')
<div class="container-fluid">
@if(Session::has('message'))
    <div class="position-relative mt-4 mb-4" aria-live="polite" aria-atomic="true">
        <div class="toast-container top-0 end-0">
            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="2000" >
                <div class="toast-body  bg-primary text-white">
                    <i class="fas fa-circle-check fa-fw"></i>
                    {{ Session::get('message') }}
                    <button type="button" class="btn-close btn-sm btn-white float-sm-end" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>

        </div>

    </div>
    @endif
    @if(Session::has('error'))
    <div class="position-relative mt-4 mb-4" aria-live="polite" aria-atomic="true">
        <div class="toast-container top-0 end-0">
            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="2000" >
                <div class="toast-body  bg-danger text-white">
                    <i class="fas fa-exclamation-circle fa-fw"></i>
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close btn-sm btn-white float-sm-end" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>

        </div>

    </div>
    @endif


    <div class="card">
        <div class="card-header">Form tambah data pengguna baru</div>
        <div class="card-body">
            <form action="{{ route('users.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kd_ptg">Kode Pengguna</label>
                    <input type="text" name="kd_ptg" id="kd_ptg" class="form-control @error('kd_ptg') is-invalid @enderror" value="{{ old('kd_ptg', $kd_ptg) }}" autocomplete="off">
                    <input type="hidden" name="id" value="{{ $id }}">
                </div>
                @error('kd_ptg')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="nm_ptg">Nama Pengguna</label>
                    <input type="text" name="nm_ptg" id="nm_ptg" class="form-control @error('nm_ptg') is-invalid @enderror" autocomplete="off" value="{{ old('nm_ptg', $nm_ptg) }}">
                </div>
                @error('nm_ptg')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="">Email Pengguna</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" value="{{ old('email', $email) }}">
                </div>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="pass" id="pass" class="form-control @error('pass') is-invalid @enderror">
                </div>
                @error('pass')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Simpan</button>
                <a href="{{ route('users') }}" class="btn btn-warning"><i class="fas fa-undo-alt"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection