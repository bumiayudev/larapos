@extends('layouts.default')

@section('content')

<div class="container-fluid px-4 pt-4">
    <h4>Daftar semua data barang</h4>
    <div class="table-responsive mt-4">
        <div class="float-end mb-2">
            @if ($user['status'] == 'Admin')
                <a href="{{ route('items.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a>
            @endif
            <button class="btn btn-sm btn-primary" id="btnGenerate"><i class="fas fa-barcode"></i> Generate Semua Barcode</button>
        </div>
        <table class="table" id="tbItem">
            <thead>
                <tr>
                    <th scope="col"><input type="checkbox" name="checked_all" id="checked_all">Pilih Semua</th>
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
        let role = "{{ $user['status'] }}";

       $('#tbItem').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "{{ route('items') }}",
            columns: [
                {data:'kd_brg', name:'kd_brg',
                    render: function(data, type, row, i){
                        return '<input type="checkbox" class="checked_code" name="item_code" value="'+row.kd_brg+'"/>';
                    }
                },
                {data: 'kd_brg', name:'kd_brg',
                 render: function(data, type, row, i) {
                    return ''+row.kd_brg+'<br /><a href="/items/generate_barcode/'+row.kd_brg+'" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-barcode fa-fw"></i> Generate Barcode</a>';
                 }
                },
                {data: 'nm_brg', name:'nm_brg'},
                {data: 'hrg_beli', name: 'hrg_beli'},
                {data:'hrg_jual' , name: 'hrg_jual'},
                {data:'action', render: function(data, type, row){
                    if(role == 'Admin'){
                        return row.action;
                    } else {
                        return '';
                    }
                }}
            ],
            columnDefs:[
                {'searchable': false, 'targets': [0]}
            ]
        });
        $('.btn-close').on('click', function() {
            $('.toast').toast('hide');
        });
        $('#btnGenerate').on('click', function() {
            let item_codes = [];
            $(".checked_code:checked").each(function() {
                item_codes.push($(this).val());
            })

            // console.log(item_codes);

            if(item_codes.length <= 0) {
                alert('Tidak ada data barang yang dipilih.');
            } else {
                $.ajax({
                    url:"{{ url('/items/send_barcode') }}",
                    data: {item_codes:item_codes, _token: "{{ csrf_token() }}"},
                    type:'POST',
                    dataType:'JSON',
                    success:function(result){
                        if(result.success == true) {
                            let codes = result.codes;
                            // console.log(codes);
                             window.open("{{ URL::to('items/preview_barcode')}}/"+codes, "_blank");
                        }
                    }

                })
            }
        })
     });
     $(document).on('click', '#checked_all', function() {
        $('.checked_code').prop('checked', this.checked);
     })
     $(document).on('click', '.code_checked', function() {
        if($('.checked_code:checked').length == $('.checked_code').length) {
            $('.checked_all').prop('checked', true);
        } else {
            $('.checked_all').prop('checked', false);
        }
     })
</script>
    
@endpush


@endsection