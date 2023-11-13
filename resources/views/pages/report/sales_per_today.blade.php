@extends('layouts.default')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Laporan Penjualan</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <label for="">Laporan Harian</label>
                        <form action="{{ route('report.sale_per_today') }}" method="POST">
                            @csrf
                            <input type="text" class="rounded" id="today" name="inputToday" autocomplete="off" value="{{ old('inputToday', $today)}}">
                            @error('inputToday')
                                <br><small class="text-danger mt-2 mb-2">{{ $message }}!</small>
                            @enderror
                            <br>
                            <button class="btn btn-sm btn-outline-dark mt-2" id="btnShow">Tampilkan</button>
                            <a href="#" role="button" class="btn btn-sm btn-outline-dark mt-2" id="btnPrint">Cetak</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($rows))
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
                        @foreach ($rows as $row)
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
            const today = "<?php echo $today ?>";
            $('#btnPrint').attr('href', "{{ url('/print/report/sales_per_today') }}?day="+today+"");

            $('#today').datepicker({
                dateFormat: "dd-mm-yy"
            }).on('change', function(){
                localStorage.setItem('today', $(this).val());
                $('#inputToday').val(getToday());
                $('#btnPrint').attr('href', "{{ url('/print/report/sales_per_today') }}?day="+getToday()+"");
            });
          
            $('#btnShow').on('click', function(){
                const today = $('input[name="today"]').val()
                $('#btnPrint').attr('href', "{{ url('/print/report/sales_per_today') }}?day="+today+"");
            });
            function getToday() {
                return localStorage.getItem('today');
            }
           })
        </script>
    @endpush
@endsection