<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Support\Facades\Session;
use DataTables;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
date_default_timezone_set("Asia/Jakarta");
use Illuminate\Support\Facades\DB;
use App\Models\DetailJual;
use App\Models\Penjualan;

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
            return 'FJ'.date('ymd').'0001';
        }

        $string = preg_replace("/[^0-9\.]/", '', $latest->faktur);

        return 'FJ'.date('ymd').sprintf('%04d',$string+1);
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

    public function load_sales(Request $request) 
    {
        $no_faktur = ($request->get('faktur')) ? $request->get('faktur') : null;
        $data = DetailJual::where('faktur', $no_faktur)
                ->get();
        
        return response()->json($data);
    }

    public function add_cart(Request $request) 
    {
        $rules = [
            'kdBrg' => 'required'
        ];

        $messages= [
            'kdBrg.required' => 'Kode atau nama barang belum dimasukan!.'
        ];

        $request->validate($rules, $messages);

        $kd_brg = $request->kdBrg;
        $product =  Barang::findOrFail($kd_brg);
        $cart = Session::get('cart');

        if(!$cart) {
            $cart = [
                $kd_brg => [
                    "code" => $product->kd_brg,
                    "name" => $product->nm_brg,
                    "price" => $product->hrg_jual,
                    "quantity" => $request->qty
                ]
            ];

            session()->put('cart', $cart);
        }

        // cek jika datanya sudah ada
       if(isset($cart[$kd_brg])) {
           $cart[$kd_brg]['quantity'] += $request->qty;
            session()->put('cart', $cart);
       }


       // jika cartnya kosong
       $cart[$kd_brg]= [
        'code' => $product->kd_brg,
        'name' => $product->nm_brg,
        'price' => $product->hrg_jual,
        'quantity' => $request->qty
       ];

       session()->put('cart', $cart);
       return redirect()->back()->with('success', "$product->kd_brg berhasil ditambahkan di keranjang.");
    }

    public function store_cart(Request $request)
    {
        $user = Session::get('user');
        $kd_brg = $request->input('kd_brg');
        $nm_brg = $request->input('nm_brg');
        $hrg_jual = $request->input('hrg_jual');
        $jml_brg = $request->input('jml_brg');
        $faktur = $request->input('faktur');
        $subtotal = intval($jml_brg) * intval($hrg_jual);
        $tanggal = date_create($request->tanggal);

        $item = Barang::where('kd_brg', $kd_brg)
                ->orWhere('nm_brg', $nm_brg)
                ->first();

        if($jml_brg > $item->jml_brg) {
            $data = [
                'success' => false,
                'message' => 'Stok barang tidak tersedia'
            ];
            return response()->json($data);
        }

        $sale = new Penjualan();
        $sale->faktur = $faktur;
        $sale->tanggal = date_format($tanggal, 'Y-m-d H:i:s');
        $sale->kd_ptg = $user['kd_ptg'];
        $sale->save();

        $details = new DetailJual();
        $details->faktur = $faktur;
        $details->kd_brg = $kd_brg;
        $details->nm_brg = $nm_brg;
        $details->hrg_jual = $hrg_jual;
        $details->jml_brg = $jml_brg;
        $details->subtotal = $subtotal;
        $details->save();

        $data = [
            'success' => true,
            'message' => 'Satu barang berhasil ditambah'
        ];
        return response()->json($data);
    }
}
