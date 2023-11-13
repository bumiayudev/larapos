@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Laporan Penjualan</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <label for="">Laporan Mingguan atau Bulanan</label>
                        <form action="{{ route('report.sale_per_week_or_month') }}" method="POST">
                            @csrf
                            <input type="text"  id="startDate" class="rounded" name="inputStartDate" autocomplete="off">
                            <input type="text"  id="endDate" class="rounded" name="inputEndDate" autocomplete="off">
                            @error('inputStartDate')
                              <br><small class="text-danger mb-2">{{ $message }}!</small>
                            @enderror
                            @error('inputEndDate')
                            <br><small class="text-danger">{{ $message }}!</small>
                            @enderror
                            <br><button class="btn btn-sm btn-outline-dark rounded mt-2">Tampilkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($result))
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Faktur</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Total Dibayar</th>
                            <th>Total Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $row)
                            <tr>
                                <td>{{ $row->faktur }}</td>
                                <td>{{ $row->item }}</td>
                                <td>{{ $row->total }}</td>
                                <td>{{ $row->dibayar }}</td>
                                <td>{{ $row->kembali }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="1">Grand Total</td>
                            <td>{{ $jmlItem }}</td>
                            <td>{{ $jmlJual }}</td>
                            <td>{{ $jmlDibayar }}</td>
                            <td>{{ $jmlKembali }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
    @push('addon-script')
        <script>
           $(function(){
            $('#startDate').datepicker({
                dateFormat: "dd-mm-yy"
            });
            $('#endDate').datepicker({
                dateFormat: "dd-mm-yy"
            });
           })
        </script>
    @endpush
@endsection