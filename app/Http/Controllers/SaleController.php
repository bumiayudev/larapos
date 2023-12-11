<?php

namespace App\Http\Controllers;

date_default_timezone_set("Asia/Jakarta");
use App\Models\Barang;
use Illuminate\Support\Facades\Session;
use DataTables;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DetailJual;
use App\Models\Penjualan;
use App\Models\Petugas;
use Carbon\Carbon;
use PDF;


class SaleController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function generateInvoiceNumber(){
        $today = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->toDateString();
        $max_faktur = DB::table('penjualan')->where('tanggal', $today)->count();
       
        if($max_faktur > 0){
             return "F".date('ymd').str_pad(intval($max_faktur) + 1, 4, '0', STR_PAD_LEFT);
           
        } else {
            return "F".date('ymd')."0001";
        }
    }

    public function index()
    {

        $no_faktur = $this->generateInvoiceNumber();

        $data = array(
            'no_faktur' => $no_faktur,
            'tgl' => date('d-m-Y'),
            'jam' => date('H:i'),
            'user' => Session::get('user'),
            'cart' => Session::get('cart')
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

    public function delete_cart($id)
    {
    
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
    
            session()->put('cart', $cart);
        }
    

        return redirect()->back();
    }

    public function reset_cart(){
        Session::pull('cart', null);
        return redirect()->back()->with('success', "Semua barang berhasil dihapus.");
    }

    public function store_cart(Request $request)
    {

        $kd_ptg = $request->input('kd_ptg');
        $faktur = $request->input('faktur');
        $tanggal = date('Y-m-d', strtotime($request->input('tgl')));
        $jam = date('H:i', strtotime($request->input('jam')));
        $item = $request->input('item');
        $total = $request->input('total');
        $dibayar = $request->input('dibayar');
        $kembali = $request->input('kembali');

        /* Simpan inputan data penjualan */
        $penjualan = new Penjualan();
        $penjualan->faktur = $faktur;
        $penjualan->tanggal = $tanggal;
        $penjualan->jam = $jam;
        $penjualan->item = $item;
        $penjualan->total = $total;
        $penjualan->dibayar = $dibayar;
        $penjualan->kembali = $kembali;
        $penjualan->kd_ptg = $kd_ptg;
        $penjualan->save();

        $datas = $request->input('data_table');
        // dd($datas);
        for ($i=0; $i < count($datas) ; $i++) { 

            /* simpan detail barang yg sudah dijual*/
            $detail = new DetailJual();
            $detail->faktur = $faktur;
            $detail->kd_brg = $datas[$i]['kd_brg'];
            $detail->nm_brg = $datas[$i]['nm_brg'];
            $detail->jml_brg = $datas[$i]['jml_brg'];
            $detail->hrg_jual = $datas[$i]['hrg_jual'];
            $detail->subtotal = $datas[$i]['subtotal'];
            $detail->save();

            /* update jumlah barang sesuai barang yg dijual */
            $item = Barang::where('kd_brg', $datas[$i]['kd_brg'])->first();
            $item->jml_brg = $item->jml_brg - $datas[$i]['jml_brg'];
            $item->save();
          
        }
    
        $data = [
            'success' => true,
            'message' => 'Transaksi berhasil disimpan',
            'cart' => Session::pull('cart', null)
        ];
       
        
        return response()->json($data, 200);
    }

    public function print_receipt($faktur)
    {
        
        $sale = Penjualan::where('faktur', $faktur)->first();
        $details = DetailJual::where('faktur', $faktur)->get();
        $user = Petugas::where('kd_ptg', $sale->kd_ptg)->first();

        $data = array(
            'sale' => $sale,
            'details' => $details,
            'user' => $user
        );
        
        // return view('print.receipt')->with($data);

        $pdf = PDF::loadView('print.receipt', $data)->setOption('A8', 'potrait');

        return $pdf->stream('cetak-struk.pdf');
    }

    function destroy_cart()
    {
        Session::pull('cart', null);
        $data = array(
            'success' => true,
            'redirect' => $this->url->to('/sales')
        );

        return response()->json($data, 200);
    }

    function show_list_sales()
    {
        $data = array(
            'user' => Session::get('user')
        );

        return view('pages.sales.list')->with($data);
    }

    function json_sales()
    {
        $rows = DB::table('penjualan')
                ->join('petugas', 'penjualan.kd_ptg', '=', 'petugas.kd_ptg')
                ->select('penjualan.*', 'petugas.nm_ptg')
                ->get();

        return DataTables::of($rows)->toJson();
    }

    function return($id)
    {
        $sale = Penjualan::where('faktur', $id)->first();
        $details = DetailJual::where('faktur', $id)->get();

        $data = array(
            'sale' => $sale,
            'tgl' => date('d-m-Y'),
            'jam' => date('H:i'),
            'user' => Session::get('user'),
            'cart' => $details
        );

        return view('pages.sales.return', $data);
    }
}
