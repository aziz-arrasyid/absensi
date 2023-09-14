<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index()
    {
        return view('login.index')->with([
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $input = $request->all();
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'username tidak boleh kosong',
                'password.required' => 'password tidak boleh kosong',
            ]
        );

        if (auth()->attempt(['username' => $input['username'], 'password' => $input['password']])) {
            $name = str_replace('_', '', str_replace('_', ' ', strtolower(Auth::user()->username)));
            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin')->with('login', 'Selamat datang '. $name);
            } elseif (auth()->user()->role == 'pegawai') {
                return redirect()->route('pegawai')->with('login', 'Selamat datang ' . $name);
            }else {
                return redirect()->route('login');
            }
        }else{
            return redirect()->route('login')->with('errorSalah', 'username atau password salah !');
        }
    }
}
