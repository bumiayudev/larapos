<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class ApiController extends Controller
{
    public function search_item(Request $request)
    {
        $result = Barang::select('*')
                ->where('kd_brg', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('nm_brg', 'LIKE', '%'.$request->input('search').'%')->get();
        $headers = [
            'Content-Type' => 'application/json;charset=utf-8',
            'Accept' => 'application/json'
        ];

        return response()->json($result, 200, $headers);
    }
}
