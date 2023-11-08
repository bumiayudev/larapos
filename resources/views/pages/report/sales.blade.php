@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Laporan Penjualan</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <form action="">
                            <div class="form-group">
                                <label for="">Laporan Harian</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <button class="btn btn-sm btn-outline-dark rounded mt-2">Tampilkan</button>
                        </form>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <form action="">
                            <div class="form-group">
                                <label for="">Laporan Mingguan</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <button class="btn btn-sm btn-outline-dark rounded mt-2">Tampilkan</button>
                        </form>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <form action="">
                            <div class="form-group">
                                <label for="">Laporan Bulanan</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <button class="btn btn-sm btn-outline-dark rounded mt-2">Tampilkan</button>
                        </form>
                    </div>
                    </div>
            </div>
        </div>
    </div>
@endsection