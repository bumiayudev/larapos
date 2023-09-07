<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->session()->get('user');
        $data = array(
            'user' => $user
        );
        return view('pages.dashboard.index', $data);
    }
}
