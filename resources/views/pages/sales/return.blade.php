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
                                <input type="text" id="faktur" value="{{ $sale->faktur }}" readonly>
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
                                            @foreach ($cart as $detail )
                                                <tr class="cart">
                                                    <td>{{ $loop->iteration }}.</td>
                                                    <td>{{ $detail->kd_brg }}</td>
                                                    <td>{{ $detail->nm_brg }}</td>
                                                    <td>{{ number_format($detail->hrg_jual, 0, ',', '.') }}</td>
                                                    <td>
                                                    <input type="hidden" class="amountItem" name="amountItem" value="{{ $detail->jml_brg }}" style="width: 60px; border-radius:8px; align-items:center;">
                                                    {{ $detail->jml_brg }}
                                                    </td>
                                                    <td id="" class="subtotal">
                                                    <input type="hidden" name="subTotal" value="{{ $detail->hrg_jual * $detail->jml_brg }}">
                                                        {{ number_format($detail->hrg_jual * $detail->jml_brg, 0, ",", ".") }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary"><i class="fas fa-undo fa-fw"></i></button>
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
                                    <a href="{{ route('sales.list') }}" role="button" class="rounded btn btn-sm btn-outline-dark">Batal</a>
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
                                        <input type="text" id="txtDibayar" value="<?php echo !empty($sale->dibayar) ? number_format($sale->dibayar, 0, ',', '.') : 0?>">
                                    </div>
                                    <div class="divKembali">
                                        <label for="txtKembali">Kembali : </label>
                                        <input type="text" id="txtKembali" value="<?php echo !empty($sale->kembali) ? number_format($sale->kembali, 0, ',', '.') : 0?>">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                </div>
        </div>

</div>
@push('addon-script')
    <script>

        totalCalculate();
        totalItem();

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
    </script>
@endpush
@endsection