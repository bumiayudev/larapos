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
                                <input type="text" id="txtItem" placeholder="Contoh : B001" class="txt-search" autocomplete="off">
                                <input type="text" id="qty" name="qty" class="qty-item" value="1">
                                <input type="hidden" id="kdBrg" name="kdBrg">
                                <button type="submit" id="btnAddSale" class="button-prepend-add mt-2"><i class="fas fa-plus"></i>Tambah</button>
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if (!empty($cart))
                                            @foreach ($cart as $details )
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
                                                    <td id="totalPrice_{{ $loop->iteration }}" class="subtotal">
                                                        <input type="hidden" id="subtotal_{{ $loop->iteration }}" name="subTotal" value="{{ $details['price'] * $details['quantity']}}">
                                                        {{ number_format($details['price'] * $details['quantity'], 0, ",", ".") }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ URL::to('sales/delete_cart/'.$details['code']) }}" class="btn btn-sm btn-outline-danger" role="button"><i class="fas fa-times fa-fw"></i> Hapus</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="6" align="center">Belum ada barang yang dimasukan...</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="fSales mt-4 mb-4">
                                <div class="actionSales">
                                    <button type="button" class="rounded btn btn-sm btn-outline-dark" id="saveCart" name="saveCart">Simpan</button>
                                    <a href="{{ route('sales.reset_cart') }}" role="button" class="rounded btn btn-sm btn-outline-dark">Batal</a>
                                </div>
                               <div class="item">
                                    <label for="totalItem">Total Item : </label>
                                    <input type="text" class="total-Item" id="totalItem" readonly>
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
        let setNumber = ()=> {
            let tableLen = $('#cartSales tbody tr').length + 1;

        }
        
        $('.btn-close').on('click', function() {
            $('.toast').toast('hide');
        });
       
        totalCalculate();

        totalItem();

        // set kd_ptg 
        let kd_ptg =  "{{ $user['kd_ptg'] }}";
        
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
       
        // fungsi kurangi qty barang
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
           totalItem();
       });

        // fungsi tambah qty barang    
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
           totalItem();
       });
       
      /* fungsi total belanja */
      function totalCalculate(){
            let total = 0;
            $('table#cartSales tbody tr.cart td.subtotal').each(function(){
                let subtotal = $(this).text() != "" ? convertToAngka($(this).text()) : 0;

                if(!isNaN(subtotal)){
                    total += subtotal;
                }
                
                $('#txtTotal').val(formatRupiah(total));
            });
    }
     
    /* fungsi total item */
    function totalItem(){
        let totalItem=0;
        $('table#cartSales tbody tr.cart').each((row, tr) => {
            let amount = $(tr).find('td input[name="amountItem"]').val();
            let item = amount !== "" ? convertToAngka(amount): 0;

            if(!isNaN(item)) {
                totalItem += item;
            }

            $('#totalItem').val(totalItem);
        })
    }

    /* fungsi total kembalian */
    $(document).on('keyup', '#txtDibayar', function(){
        let dibayar = $(this).val();
        $(this).val(formatRupiah(dibayar));

        let totalHarga = convertToAngka($('#txtTotal').val());
        let totalBayar = convertToAngka($(this).val());
        let totalKembali = parseInt(totalBayar) - parseInt(totalHarga);

        if(Math.sign(totalKembali) == -1){
            $('#txtKembali').val("-"+formatRupiah(totalKembali));
        } else if(Math.sign(totalKembali) == 1){
            $('#txtKembali').val(formatRupiah(parseInt(totalKembali)));
        } else if(Math.sign(totalKembali) == 0){
            $('#txtKembali').val(totalKembali);
        }

    });

    /* fungsi proses simpan cart */
    $('#saveCart').on('click', function(e){
        e.preventDefault();
        let dataTable = [];
        let faktur = $('#faktur').val();
        $('#cartSales tbody tr').each((row, tr) => {
            let hrg = convertToAngka($(tr).find('td:eq(3)').text());
            let jml = convertToAngka($(tr).find('td:eq(4) input[name=amountItem]').val());
            let subtotal = convertToAngka($(tr).find('td:eq(5)').text());
            
            if( $(tr).find('td:eq(1)').text() == "" ){
                alert('Mohon maaf belum ada barang yang dimasukkan');
            } 


            let sub = {
                    'kd_brg': $(tr).find('td:eq(1)').text(),
                    'nm_brg': $(tr).find('td:eq(2)').text(),
                    'hrg_jual': hrg,
                    'jml_brg': jml,
                    'subtotal': subtotal
    
            }
            dataTable.push(sub);
            
        });
        
        // console.log(dataTable);
        if((convertToAngka($('#txtDibayar').val()) < convertToAngka($('#txtTotal').val())) || $('#txtDibayar').val() == ""){
            alert('Nominal pembayaran masih kurang dari nominal belanja');
        } else {
            
            $.ajax({
                    url: "{{ url('/api/sales/store_cart') }}",
                    type: "POST",
                    dataType: "json",
                    data: { 'data_table': dataTable,'faktur': faktur,
                            '_token': '{{ csrf_token() }}',
                            'tgl': $('#tgl').val(),
                            'jam': $('#jam').val(),
                            'item': parseInt($('#totalItem').val()),
                            'total': convertToAngka($('#txtTotal').val()),
                            'dibayar': convertToAngka($('#txtDibayar').val()),
                            'kembali': convertToAngka($('#txtKembali').val()),
                            'kd_ptg': kd_ptg
                    },
                    success: function(res){
                        if(res.success == true){
                            alert(res.message)
                            setTimeout(() => {
                                
                                location.href = "{{ URL::to('/sales/print_receipt') }}/"+faktur+"";
                                resetCart();

                            }, 2000);
                            
                        }
        
                    }
             });

        } 

    });

    function resetCart(){
        $.ajax({
            url: "{{ route('sales.delete_cart') }}",
            success: function(res){
                if(res.success == true){
                    location.href = res.redirect;
                }
            }
        })
    }
    </script>
   @endpush
@endsection