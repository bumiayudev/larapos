@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Laporan Penjualan</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <label for="">Laporan Harian</label>
                        <form action="">
                            <input type="text" class="" value="{{ date('d/m/Y') }}" id="today">
                        </form>
                        <button class="btn btn-sm btn-outline-dark rounded mt-2">Tampilkan</button>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <label for="">Laporan Mingguan atau Bulanan</label>
                        <form action="">
                            <input type="text"  id="startDate">
                            <input type="text"  id="endDate">
                        </form>
                        <button class="btn btn-sm btn-outline-dark rounded mt-2">Tampilkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('addon-script')
        <script>
           $(function(){
            $('#today').datepicker();
            $('#startDate').datepicker();
            $('#endDate').datepicker();
           })
        </script>
    @endpush
@endsection