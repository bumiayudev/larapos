<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            width:280px;
            height: auto;
        }

        .divider{
            margin-top: 4px;
            margin-bottom: 4px;
            width: 280px;
            border-top: 3px dotted #bbb;
        }

        .shopHeader{
            text-align: center;
            margin: 2px;
        }

        #tbHeader, #tbDetail{
            font-weight: normal;
            font-size: 14px;
        }
       
        .info{
            font-weight: 400;
            text-align: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="shopHeader">
        <h4>Rafa Store</h4>
        <p>Jl.Raya Bekasi KM 111 no.45</p>
        <p>No.Kontak : 087884395611</p>
    </div>
    <div class="divider"></div>
    <div id="tbHeader">
        <table>
            <tr>
               <td style="text-align: left; margin-right: 100px">{{  $sale->tanggal }}</td>
               <td>{{ $user->nm_ptg }}</td>
            </tr>
            <tr>
                <td style="text-align: left;">{{ $sale->jam }}</td>
            </tr>
        </table>

    </div>
    <div class="divider"></div>
    <div id="tbDetail">
        <table>
        @foreach ($details as $detail )
                <tr>
                    <td style="text-align: left; margin-right: 40px">
                        {{ $detail->nm_brg }} <br>
                        {{ $detail->jml_brg }} x {{ $detail->hrg_jual }}
                    </td>
                    <td style="text-align: right; margin-left: 60px"> Rp.{{ number_format($detail->subtotal, 0, ',', '.')  }} </td>
                </tr>
        @endforeach
        </table>
    </div>
    <div class="divider"></div>
    <div id="total">
        <table>
            <tr>
                <td style="text-align: left;">Total Qty : {{ $sale->item }}</td>
            </tr>
            <tr>
                <td style="text-align: left; margin-right: 40px">Sub Total</td>
                <td style="text-align: right; margin-left: 60px">Rp.{{ number_format($sale->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="text-align: left; margin-right: 40px"><strong>Total</strong></td>
                <td style="text-align: right; margin-left: 60px"><strong>Rp.{{ number_format($sale->total, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
    <div class="divider"></div>
    <div class="info">
        <p>Terimakasih telah berbelanja.</p>
        <p>Kritik dan Saran</p>
        <p>email : admin.info@gmail.com</p>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>