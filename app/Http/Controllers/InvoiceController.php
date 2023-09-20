<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    // create automatic invoicing

    public function automatic_invoicing()
    {
        date_default_timezone_set("Asia/Jakarta");
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

    public function invoice_number()
    {
        echo $this->automatic_invoicing();
    }
}
