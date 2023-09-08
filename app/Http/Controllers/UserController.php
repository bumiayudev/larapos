<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Petugas;
use App\Http\Requests\PetugasLoginRequest as LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\UrlGenerator;

class UserController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function signin()
    {
        if(Session::get('user') !== null){
            return redirect()->route('home');
        }

        $data = array();

        return view('pages.auth.signin', $data);
    }

    public function signup()
    {
        $data = array();
        
        return view('pages.auth.signup', $data);
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $row = Petugas::where('email', $data['email'])->first();
    
        if (!$row || !Hash::check($data['password'], $row->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
            
        } 
        
        Session::put('user', $row);
            
        return redirect()->intended('/');
    }

    public function logout()
    {
        Session::pull('user', null);

        return redirect()->route('signin');
    }

    public function list(Request $request)
    {
        $data = array(
            'user'=> Session::get('user')
        );

        if($request->ajax()) {
            $model = Petugas::query();

            return DataTables::eloquent($model)
            ->addColumn('action', function(Petugas $ptg) {
                return '<a href="'.$this->url->to('/users/edit/'.$ptg->kd_ptg).'" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a> | <a href="'.$this->url->to('/users/delete/'.$ptg->kd_ptg).'" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>';
            })
            ->toJson();
        }

        return view('pages.users.list', $data);
    }

    public function create(){
        $data = array(
            'user' => Session::get('user')
        );

        return view('pages.users.create', $data);
    }

    public function edit($id = 1){
        return 'Say hello';
    }

}
