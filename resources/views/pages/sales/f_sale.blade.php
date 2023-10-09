@extends('layouts.default') 

@section('content')

<div class="container-fluid">
    @if(Session::has('success'))
    <div class="position-relative mt-4 mb-4" aria-live="polite" aria-atomic="true">
        <div class="toast-container top-0 end-0">
            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="2000" >
                <div class="toast-body  bg-primary text-white">
                    <i class="fas fa-circle-check fa-fw"></i>
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close btn-sm btn-white float-sm-end" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>

        </div>

    </div>
    @endif
    <div class="container-fluid">
    <div class="card mt-4 mb-4 cardSales">
                    <div class="card-header">Penjualan</div>
                    <div class="card-body bodySales">
                        <div class="headerFaktur">
                            <div class="hLeft">
                                <label for="faktur">Faktur : </label>
                                <input type="text" id="faktur" value="{{ $no_faktur }}" readonly>
                            </div>
                            <div class="hMid">
                                <label for="tgl">Tanggal : </label>
                                <input type="text" id="tgl" value="{{ $tgl }}" readonly>
                            </div>
                            <div class="hRight">
                                <label for="Jam">Jam :</label>
                                <input type="text" id="jam" value="{{ $jam }}" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="form-search">
                            <form action="{{ route('sales.add_cart') }}" method="POST">
                                @csrf
                            <label for="txtItem">Masukan kode atau nama barang dengan benar</label>
                            <div class="input-search mb-3 mt-3">
                                @error('kdBrg')
                                    <div class="mt-2 mb-2 alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" id="txtItem" placeholder="Contoh : B001" class="txt-search">
                                <input type="text" id="qty" name="qty" class="qty-item" value="1">
                                <input type="hidden" id="kdBrg" name="kdBrg">
                                <button type="submit" id="btnAddSale" class="button-prepend-add"><i class="fas fa-plus"></i>Tambah</button>
                            </div>
                            </form>
                        </div>
                        <div class="bTrans mt-4">
                            <div class="table-responsive">
                                <table class="table" id="cartSales">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode</th>
                                            <th>Nama Barang</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (session('cart'))
                                            @foreach (session('cart') as $details )
                                              
                                                <tr class="cart">
                                                    <td>{{ $loop->iteration }}.</td>
                                                    <td>{{ $details['code'] }}</td>
                                                    <td>{{ $details['name'] }}</td>
                                                    <td>
                                                        <input type="hidden" name="price" id="price_{{ $loop->iteration }}" value="{{ $details['price'] }}">
                                                        {{ number_format($details['price'], 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        <button class="minQty" data-id="{{$loop->iteration}}">-</button>
                                                        <input type="text" class="amountItem" id="amountItem_{{$loop->iteration}}" name="amountItem" value="{{ $details['quantity'] }}" style="width: 60px; border-radius:8px; align-items:center;">
                                                        <button class="addQty" data-id="{{$loop->iteration}}">+</button>
                                                    </td>
                                                    <td id="totalPrice_{{ $loop->iteration }}">
                                                        <input type="hidden" class="subtotal" id="subtotal_{{ $loop->iteration }}" name="subTotal" value="{{ $details['price'] * $details['quantity']}}">
                                                        {{ number_format($details['price'] * $details['quantity'], 0, ",", ".") }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="6" align="center">Belum ada produk...</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="fSales mt-4 mb-4">
                                <div class="actionSales">
                                    <button class="rounded btn btn-sm btn-outline-dark">Simpan</button>
                                    <button class="rounded btn btn-sm btn-outline-dark">Batal</button>
                                </div>
                               
                                <div class="inputPayment">
                                    <div class="divTotal">
                                        <label for="txtTotal">Total : </label>
                                        <input type="text" id="txtTotal">
                                    </div>
                                    <div class="divDibayar">
                                        <label for="txtDibayar">Dibayar : </label>
                                        <input type="text" id="txtDibayar">
                                    </div>
                                    <div class="divKembali">
                                        <label for="txtKembali">Kembali : </label>
                                        <input type="text" id="txtKembali">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </div>

    @push('addon-script')
    <!-- Jquery Autocomplete  -->
    <script src="{{ asset('lib/jquery/jquery-ui.js') }}"></script>
    <script>
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('.btn-close').on('click', function() {
            $('.toast').toast('hide');
        });
       
        totalCalculate();

        // searching item code or item name using autocomplete jquery ui
        $(document).on('keyup', '#txtItem', function(){
         let q = $(this).val();
         $(this).autocomplete({
             source: function(request, response){
                 $.ajax({
                     url: "{{ route('api.search_item') }}",
                     dataType: "JSON",
                     method: "POST",
                     headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                     data: {
                         search : request.term
                     },
                     success: function(data){
                         let uniques = [],
                             choices = [];

                         data.forEach(function(item){
                             let value = item.nm_brg.trim().toLowerCase();
                             if(uniques.indexOf(value) < 0 ){
                                 choices.push({
                                     label: item.kd_brg +' - '+ item.nm_brg,
                                     value: item.kd_brg +' - '+ item.nm_brg,
                                     data: item,
                                     
                                 });
                                 uniques.push(value);
                             }
                         })
                         response(choices);
                     },
                     
                 })
             },
             autoFocus: true,
            minLength: 1,
            select: function(event, selectedData){
                // console.log(selectedData);
                $(this).val(selectedData.item.data.kd_brg+' - '+selectedData.item.data.nm_brg);
                $('#kdBrg').val(selectedData.item.data.kd_brg);
                return false;
            },
            appendTo: $(this).parent()

         }).data('ui-autocomplete')._renderItem = function(ul, item){
             return $("<li class='ui-autocomplete-row'></li>")
                 .data("item.autocomplete", item)
                 .append(item.label)
                 .appendTo(ul);
             };
         
        })
       
       $(document).on('click', '.minQty', function(e){
            e.preventDefault();
            let id = $(this).data('id');
           let qty = $('#amountItem_'+id+'').val();
           let price = $('#price_'+id+'').val();
           let total = (parseInt(qty) - 1) * parseInt(price);
           
           // decrementing qty
           $('#amountItem_'+id+'').val(parseInt(qty)-1);
           $('#subtotal_'+id+'').val(total);
           $('table').find('tr td#totalPrice_'+id+'').text(formatRupiah(parseInt(total)));
           totalCalculate();
       });

       $(document).on('click', '.addQty', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
           let qty = $('#amountItem_'+id+'').val();
           let price = $('#price_'+id+'').val();
           let total = (parseInt(qty) + 1) * parseInt(price);

           // incrementing qty
           $('#amountItem_'+id+'').val(parseInt(qty)+1);
           $('#subtotal_'+id+'').val(total);
           $('table').find('tr td#totalPrice_'+id+'').text(formatRupiah(parseInt(total)));
           totalCalculate();
       });
       
      
        /* Fungsi formatRupiah */
        function formatRupiah(angka){
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
        
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
        
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        /* fungsi total belanja*/
        function totalCalculate(){
            let total = 0;
            $('table tbody tr.cart td input.subtotal').each(function(){
                let subtotal = $(this).val() != "" ? parseInt($(this).val()) : 0;

                if(!isNaN(subtotal)){
                    total += subtotal;
                }
                
                // console.log(total)
                $('#txtTotal').val(formatRupiah(total));
            });
        }
    </script>
   @endpush
@endsection