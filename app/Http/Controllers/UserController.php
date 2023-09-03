<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Petugas;
use App\Http\Requests\PetugasLoginRequest as LoginRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signin()
    {
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
        $request->session()->regenerate();
            
        return redirect()->intended('/');
    }
}
