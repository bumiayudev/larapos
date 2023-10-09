<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class ApiController extends Controller
{
    public function search_item(Request $request)
    {
        $search = $request->input('search');
        $result = Barang::where('kd_brg', 'LIKE', "%$search%")
                   ->orWhere('nm_brg', 'LIKE', "%$search%")->get(); 
        $headers = [
            'Content-Type' => 'application/json;charset=utf-8',
            'Accept' => 'application/json'
        ];

        return response()->json($result, 200, $headers);
    }
}
