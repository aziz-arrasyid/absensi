<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

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
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt(['username' => $input['username'], 'password' => $input['password']])) {
            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin');
            } elseif (auth()->user()->role == 'pegawai') {
                return redirect()->route('pegawai');
            }else {
                return redirect()->route('login');
            }
        }
    }
}
