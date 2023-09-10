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
                return '<a href="'.$this->url->to('/users/edit/'.$ptg->kd_ptg).'" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a> | <a href="'.$this->url->to('/users/delete/'.$ptg->kd_ptg).'" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin dihapus?\')"><i class="fas fa-trash"></i> Hapus</a>';
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

    public function store(Request $request){
        $rules = [
            'kd_ptg' => ['required','max:8'],
            'nm_ptg' => ['required'],
            'email' => ['required', 'email'],
            'pass' => ['required', 'min:6']
        ];

        $messages = [
            'kd_ptg.required' => 'Kode pengguna  tidak boleh kosong',
            'kd_ptg.max' => 'Kode pengguna maksimal isinya 8 digit',
            'nm_ptg.required' => 'Nama pengguna tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak sesuai',
            'pass.required' => 'Password tidak boleh kosong',
            'pass.min' => 'Minimal panjang panjang password 6 karakter'
        ];

        $request->validate($rules, $messages);

        $user = Petugas::where('kd_ptg', $request->kd_ptg)->first();

        if($user) {
            return back()->with('error', 'Data pengguna sudah ada');
        }

        $data = new Petugas();
        $data->kd_ptg = $request->kd_ptg;
        $data->nm_ptg = $request->nm_ptg;
        $data->email = $request->email;
        $data->password = Hash::make($request->pass);
        $data->status = "Kasir";
        $data->save();

        return back()->with('message', 'Data pengguna berhasil ditambahkan.');
        
    }

    public function edit($id){
        $user = Petugas::where('kd_ptg', $id)->first();

        $data = array(
            'id' => $user->kd_ptg,
            'kd_ptg'=> $user->kd_ptg,
            'nm_ptg' => $user->nm_ptg,
            'email' => $user->email,
            'user' => Session::get('user')
        );

        return view('pages.users.edit', $data);


    }

    public function update(Request $request){

        $rules = [
            'kd_ptg' => ['required'],
            'nm_ptg' => ['required'],
            'email' => ['required', 'email'],
            'pass' => ['required']
        ];

        $messages = [
            'kd_ptg.required' => 'Kode pengguna tidak boleh kosong',
            'nm_ptg.required' => 'Nama pengguna tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak sesuai',
            'pass.required' => 'Password tidak boleh kosong'
        ];

        $request->validate($rules, $messages);

        $user = Petugas::where('kd_ptg', $request->id)->first();
        $user->kd_ptg = $request->kd_ptg;
        $user->nm_ptg = $request->nm_ptg;
        $user->email = $request->email;
        $user->password = Hash::make($request->pass);
        $user->save();

        return back()->with('message', 'Data pengguna berhasil diubah');

    }

    public function delete($id) {
        $user = Petugas::where('kd_ptg', $id)->first();

        if($user) {
            Petugas::destroy($id);

            return back()->with('message', 'Data pengguna '.$user->nm_ptg.' berhasil dihapus');
        } else {
            return back()->with('error', 'Data pengguna tidak ditemukan.');
        }
    }

}
