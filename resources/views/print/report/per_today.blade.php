<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan penjualan per harian</title>
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
@if (!empty($rows))
    <table class="table">
            <thead>
                <tr>
                    <th>No. Faktur</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Total Dibayar</th>
                    <th>Total Kembali</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <td>{{ $row->faktur }}</td>
                        <td>{{ $row->item }}</td>
                        <td>{{ $row->total }}</td>
                        <td>{{ $row->dibayar }}</td>
                        <td>{{ $row->kembali }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1">Grand Total</td>
                    <td>{{ $jmlItem }}</td>
                    <td>{{ $jmlJual }}</td>
                    <td>{{ $jmlDibayar }}</td>
                    <td>{{ $jmlKembali }}</td>
                </tr>
            </tfoot>
        </table>
@endif
<div class="info">
    <p>Dibuat oleh : <strong>{{ strtoupper($user->nm_ptg)  }}</strong></p>
</div>
</body>
</html>