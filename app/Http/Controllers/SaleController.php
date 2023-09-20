<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use DataTables;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
date_default_timezone_set("Asia/Jakarta");
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function invoice_number()
    {
        $latest = DB::table('penjualan')
                ->where('faktur', 'select max(faktur) from penjualan')
                ->orderBy('faktur', 'DESC')
                ->first();

        if(!$latest) {
            return 'INV'.date('ymd').'0001';
        }

        $string = preg_replace("/[^0-9\.]/", '', $latest->faktur);

        return 'INV'.date('ymd').sprintf('%04d',$string+1);
    }

    public function index()
    {
        $data = array(
            'no_faktur' => $this->invoice_number(),
            'tgl' => date('d-m-Y'),
            'jam' => date('H:i'),
            'user' => Session::get('user')
        );

        return view('pages.sales.f_sale', $data);
    }
}
