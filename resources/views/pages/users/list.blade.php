@extends('layouts.default')

@section('content')

<div class="container-fluid px-4 pt-4">
    <h4>Daftar semua data pengguna</h4>
    <div class="float-end mb-2"><a href="{{ route('users.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
    <div class="table-responsive mt-4">
        <table class="table table-primary" id="tbUser">
            <thead>
                <tr>
                    <th scope="col">Kode Petugas</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
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

       $('#tbUser').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users') }}",
            columns: [
                {data: 'kd_ptg', name:'kd_ptg'},
                {data: 'nm_ptg', name:'nm_ptg'},
                {data: 'email', name: 'email'},
                {data:'action' , name: 'action'}
            ]
        });
        $('.btn-close').on('click', function() {
            $('.toast').toast('hide');
        });
     });
</script>
    
@endpush


@endsection