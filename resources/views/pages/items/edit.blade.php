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
        <div class="card-header">Form edit data barang</div>
        <div class="card-body">
            <form action="{{ route('items.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kd_brg">Kode Barang</label>
                    <input type="text" name="kd_brg" id="kd_brg" class="form-control @error('kd_brg') is-invalid @enderror" value="{{ old('kd_brg', $kd_brg) }}" autocomplete="off">
                </div>
                @error('kd_brg')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="nm_brg">Nama Barang</label>
                    <input type="text" name="nm_brg" id="nm_brg" class="form-control @error('nm_brg') is-invalid @enderror" autocomplete="off" value="{{ old('nm_brg', $nm_brg) }}">
                </div>
                @error('nm_brg')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="hrg_beli">Harga Beli</label>
                    <input type="text" name="hrg_beli" id="hrg_beli" class="form-control @error('hrg_beli') is-invalid @enderror" autocomplete="off" value="{{ old('hrg_beli', $hrg_beli) }}">
                </div>
                @error('hrg_beli')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="hrg_jual">Harga Jual</label>
                    <input type="text" name="hrg_jual" id="hrg_jual" class="form-control @error('hrg_jual') is-invalid @enderror" value="{{ old('hrg_jual', $hrg_jual) }}">
                </div>
                @error('hrg_jual')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="jml_brg">Jumlah</label>
                    <input type="text" name="jml_brg" id="jml_brg" class="form-control @error('jml_brg') is-invalid @enderror" value="{{ old('jml_brg', $jml_brg) }}">
                </div>
                @error('jml_brg')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" value="{{ old('satuan', $satuan) }}">
                </div>
                @error('satuan')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Simpan</button>
                <a href="{{ route('items') }}" class="btn btn-warning"><i class="fas fa-undo-alt"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection