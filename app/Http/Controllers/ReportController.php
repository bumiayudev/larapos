<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
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

    public function sales_per_today()
    {
        $data = array(
            'user'=> Session::get('user'),
            'today'=> Date('d-m-Y')
        );

        return view('pages.report.sales_per_today')->with($data);
    }

    public function sales_per_week_or_month()
    {
        $data = array(
            'user'=> Session::get('user'),
            
        );

        return view('pages.report.sales_per_week_or_month')->with($data);
    }

    public function per_today(Request $request)
    {
        Session::pull('rows', null);

        $rules = array(
            'inputToday' => 'required'
        );

        $messages = array(
            'inputToday.required' => 'Belum ada tanggal dipilih'
        );

        $request->validate($rules, $messages);
        $today = strtotime($request->inputToday);

        $rows = Penjualan::where('tanggal', date('Y-m-d', $today))->get();
        $jmlItem = Penjualan::where('tanggal', date('Y-m-d', $today))->sum('item');
        $jmlJual = Penjualan::where('tanggal', date('Y-m-d', $today))->sum('total');
        $jmlDibayar = Penjualan::where('tanggal', date('Y-m-d', $today))->sum('dibayar');
        $jmlKembali = Penjualan::where('tanggal', date('Y-m-d', $today))->sum('kembali');

        $data = array(
            'user'=> Session::get('user'),
            'rows' =>  $rows,
            'today' => date('d-m-Y', $today),
            'jmlItem'=> $jmlItem,
            'jmlJual'=>$jmlJual,
            'jmlDibayar'=>  $jmlDibayar,
            'jmlKembali'=> $jmlKembali
        );
        // dd($data);
        return view('pages.report.sales_per_today')->with($data);
    }


    public function per_week_or_month(Request $request)
    {
       
        $rules = array(
            'inputStartDate' => 'required',
            'inputEndDate' => 'required'
        );

        $messages = array(
            'inputStartDate.required' => 'Tanggal mulai belum dipilih',
            'inputEndDate.required' => 'Tanggal akhir belum dipilih',
        );

        $request->validate($rules, $messages);

        $startDate = strtotime($request->inputStartDate);
        $endDate = strtotime($request->inputEndDate);

        $rows  = Penjualan::whereBetween('tanggal', array(date('Y-m-d', $startDate), date('Y-m-d', $endDate)))->get();
        $jmlItem = Penjualan::whereBetween('tanggal', array(date('Y-m-d', $startDate), date('Y-m-d', $endDate)))->sum('item');
        $jmlJual = Penjualan::whereBetween('tanggal', array(date('Y-m-d', $startDate), date('Y-m-d', $endDate)))->sum('total');
        $jmlDibayar = Penjualan::whereBetween('tanggal', array(date('Y-m-d', $startDate), date('Y-m-d', $endDate)))->sum('dibayar');
        $jmlKembali = Penjualan::whereBetween('tanggal', array(date('Y-m-d', $startDate), date('Y-m-d', $endDate)))->sum('kembali');

        $data = array(
            'user'=> Session::get('user'),
            'result' => $rows,
            'jmlItem'=> $jmlItem,
            'jmlJual'=> $jmlJual,
            'jmlDibayar'=> $jmlDibayar,
            'jmlKembali'=> $jmlKembali
        );

        // dd($data);
        return view('pages.report.sales_per_week_or_month')->with($data);
    }
}
