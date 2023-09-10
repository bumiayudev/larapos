@extends('layouts.default')

@section('content')

<div class="container-fluid px-4 pt-4">
    <h4>Daftar semua data barang</h4>
    <div class="float-end mb-2"><a href="{{ route('items.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
    <div class="table-responsive mt-4">
        <table class="table table-primary" id="tbItem">
            <thead>
                <tr>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Aksi</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
    
</div>
@push('addon-script')
<script type="text/javascript">
     $(function (){
       'use strict';

       $('#tbItem').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('items') }}",
            columns: [
                {data: 'kd_brg', name:'kd_brg'},
                {data: 'nm_brg', name:'nm_brg'},
                {data: 'hrg_beli', name: 'hrg_beli'},
                {data:'hrg_jual' , name: 'hrg_jual'},
                {data:'action', name:'action'}
            ]
        });
     });
</script>
    
@endpush


@endsection