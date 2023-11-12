<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->session()->get('user');
        $today = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->toDateString();
        $total_today_sale = Penjualan::where('tanggal', $today)->sum('total');
        $total_all_sales = Penjualan::all()->sum('total');
        $total_items = Barang::all()->count('kd_brg');
        $total_item_sale = Penjualan::all()->sum('item');

        $data = array(
            'user' => $user,
            'total_today_sale' => $total_today_sale,
            'total_all_sales' => $total_all_sales,
            'total_items' => $total_items,
            'total_item_sale' => $total_item_sale
        );
        return view('pages.dashboard.index', $data);
    }
}
