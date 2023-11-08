<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan master barang</title>
    <style>
        .title{
            margin-bottom: 14px;
        }

        table, th, td{
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td{
            border-style: groove;
        }

        tr:nth-child(even) {
            background-color: #D6EEEE;
        }
    </style>
</head>
<body>
    <div class="title">
        <h4>Laporan Data Barang</h4>
        <small>Tanggal Cetak : {{ Date('d-m-Y H:i:s') }}</small>
    </div>
    <table class="table">
        <thead> 
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Jumlah Barang</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody id="tbItem">
            @foreach ($items as $item )
                <tr>
                    <td>{{ $item->kd_brg }}</td>
                    <td>{{ $item->nm_brg }}</td>
                    <td>{{ $item->hrg_beli }}</td>
                    <td>{{ $item->hrg_jual }}</td>
                    <td>{{ $item->jml_brg }}</td>
                    <td>{{ $item->satuan }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Grand Total</td>
                <td>Rp  {{ number_format($totHrgBeli,0,',', '.') }}</td>
                <td>Rp  {{ number_format($totHrgJual,0,',', '.') }}</td>
                <td colspan="2">{{ $totStok }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="info">
        <p>Dibuat oleh : <strong>{{ strtoupper($user->nm_ptg)  }}</strong></p>
    </div>
</body>
</html>