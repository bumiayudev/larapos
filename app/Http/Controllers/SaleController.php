<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use DataTables;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function index()
    {
        $data = array(
            'user' => Session::get('user')
        );

        return view('pages.sales.f_sale', $data);
    }
}
