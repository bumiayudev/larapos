@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <h3 class="mt-2 mb-2 py-2">Daftar transaksi penjualan</h3>

    <div class="table-responsive">
        <table id="listSales" class="table">
            <thead>
                <tr>
                    <th>No. Faktur</th>
                    <th>Tanggal dan Jam</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Dibayar</th>
                    <th>Kembali</th>
                    <th>Petugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@push('addon-script')
    <script>
        $(function(){
            $('#listSales').DataTable({
                ajax:{
                    url: "{{ url('/api/sales/json') }}",
                    type: 'GET'
                },
                processing: true,
                serverSide: true,
                columns: [
                    {
                        data: 'faktur'
                    },
                    {
                        data: 'tanggal',
                        render: function(data, type, row){
                            return row.tanggal +' '+ row.jam;
                        }
                    },
                    {
                        data: 'item'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'dibayar'
                    },
                    {
                        data: 'kembali'
                    },
                    {
                        data: 'nm_ptg'
                    },
                    {
                        data: 'faktur',
                        render: function(data, type, row){
                            let action = `
                            <a href="{{ URL::to('/sales/print_receipt') }}/${row.faktur}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fas fa-print"></i></a> |
                            <a href='#' class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a> | 
                            <a href='#' class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                            `;
                            return action;
                        }
                    }
                ]
            });
        })
    </script>
@endpush
@endsection