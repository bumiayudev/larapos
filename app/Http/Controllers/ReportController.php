<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function items()
    {
        $data = array(
            'user'=> Session::get('user'),
            'items'=> Barang::all(),
            'totHrgBeli'=> Barang::all()->sum('hrg_beli'),
            'totHrgJual'=> Barang::all()->sum('hrg_jual'),
            'totStok'=> Barang::all()->sum('jml_brg')
        );

        $pdf = PDF::loadView('pages.report.item', $data);

        return $pdf->stream('cetak-laporan-master-barang.pdf');
    }

    public function sales()
    {
        $data = array(
            'user'=> Session::get('user')
        );

        return view('pages.report.sales')->with($data);
    }
}
