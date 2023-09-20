<div class="container-fluid">
@extends('layouts.default') 

@section('content')
    <div class="container-fluid">
    <div class="card mt-4 mb-4 cardSales">
                    <div class="card-header">Penjualan</div>
                    <div class="card-body bodySales">
                        <div class="headerFaktur">
                            <div class="hLeft">
                                <label for="faktur">Faktur : </label>
                                <input type="text" id="faktur" placeholder="{{ $no_faktur }}" readonly>
                            </div>
                            <div class="hMid">
                                <label for="tgl">Tanggal : </label>
                                <input type="text" id="tgl" placeholder="{{ $tgl }}" readonly>
                            </div>
                            <div class="hRight">
                                <label for="Jam">Jam :</label>
                                <input type="text" id="jam" placeholder="{{ $jam }}" readonly>
                            </div>
                        </div>
                        <div class="bTrans mt-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Barang</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>A0001</td>
                                            <td>Buku Tulis</td>
                                            <td>20000</td>
                                            <td>2</td>
                                            <td>40000</td>
                                        </tr>
                                        <tr>
                                            <td>B0001</td>
                                            <td>Pencil Warna</td>
                                            <td>20000</td>
                                            <td>2</td>
                                            <td>80000</td>
                                        </tr>
                                        <tr>
                                            <td>C0001</td>
                                            <td>Pulpen</td>
                                            <td>1000</td>
                                            <td>20</td>
                                            <td>20000</td>
                                        </tr>
                                        <tr>
                                            <td>D0001</td>
                                            <td>Buku Gambar</td>
                                            <td>20000</td>
                                            <td>1</td>
                                            <td>20000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="fSales mt-4 mb-4">
                                <div class="actionSales">
                                    <button class="rounded btn btn-sm btn-outline-dark">Simpan</button>
                                    <button class="rounded btn btn-sm btn-outline-dark">Batal</button>
                                </div>
                                <div class="inputItem">
                                    <label for="txtItem">Item : </label>
                                    <input type="text" id="txtItem" placeholder="B001">
                                    <div class="presentation"></div>
                                </div>
                                <div class="inputPayment">
                                    <div class="divTotal">
                                        <label for="txtTotal">Total : </label>
                                        <input type="text" id="txtTotal" placeholder="120000">
                                    </div>
                                    <div class="divDibayar">
                                        <label for="txtDibayar">Dibayar : </label>
                                        <input type="text" id="txtDibayar" placeholder="120000">
                                    </div>
                                    <div class="divKembali">
                                        <label for="txtKembali">Kembali : </label>
                                        <input type="text" id="txtKembali" placeholder="30000">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </div>

   @push('addon-script')
    <script>
        $(function() {
            let listItem = $('.presentation');
            listItem.html('');
            $('#txtItem').on('keyup', function(){
                let txtItem = $(this).val();

                if(!txtItem || txtItem == ''){
                    listItem.html('');
                } else {
                    
                    $.ajax({
                        url: '/api/items',
                        type: 'POST',
                        data: { search : txtItem},
                        dataType: 'JSON',
                        success: function(result) {
                            if(result.length) {
                                result.forEach((row) => {
                                    listItem.html('\
                                    [ <a href="#" class="item" onclick="addCart(this)" data-kdbrg="'+row.kd_brg+'" data-nmbrg="'+row.nm_brg+'" data-hrg="'+row.hrg_jual+'" data-jml="1">'+row.kd_brg+' - '+row.nm_brg+'</a> ]')
                                });
                            } else {
                                listItem.html('Data barang tidak ditemukan!.');
                            }
                        },
                        error: function() {
                            if(txtItem == '' || txtItem == undefined){
                                listItem.html('');
                            }
                        }
                    })
                }
            })
        });
        function addCart(el) {
            let kdBrg = $(el).data('kdbrg');
            let nmBrg = $(el).data('nmbrg');
            let hrg = $(el).data('hrg');
            let jml = $(el).data('jml');
        }
    </script>
   @endpush
@endsection