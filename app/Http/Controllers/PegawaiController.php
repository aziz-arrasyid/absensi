<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seksi;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));

        return view('admin.pegawai.index')->with([
            'name' => $nama,
            'title' => 'Data pegawai',
            'dataTitle' => 'Data Pegawai',
            'addData' => 'Tambah Pegawai',
            'editData' => 'Edit Pegawai',
            'Pegawai' => Pegawai::all(),
            'Jabatan' => Jabatan::all(),
            'Bidang' => Bidang::all(),
            'Seksi' => Seksi::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'regNumber' => 'required|numeric',
                'namaLengkap' => 'required',
                'jabatan_id' => 'required',
                'bidang_id' => 'required',
                'seksi_id' => 'required',
            ],
            [
                'regNumber.numeric' => 'Data NIP/NRHS harus berupa angka',
                'regNumber.required' => 'Data NIP/NRHS tidak boleh kosong',
                'jabatan_id.required' => 'Data jabatan pegawai tidak boleh kosong',
                'bidang_id.required' => 'Data bidang pegawai tidak boleh kosong',
                'seksi_id.required' => 'Data seksi pegawai tidak boleh kosong',
                'namaLengkap.required' => 'Data Lengkap tidak boleh kosong',
            ]
        );

        $pegawai = Pegawai::create($request->all());
        User::create([
            'username' => str_replace(' ', '_', strtolower($pegawai->namaLengkap)),
            'role' => '1',
            'password' => bcrypt('pegawai'),
        ]);

        $message = 'Data ' . $pegawai->namaLengkap . ' Berhasil ditambahkan';
        return redirect()->route('data-pegawai.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $data_pegawai)
    {
        return response()->json($data_pegawai);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $data_pegawai)
    {
        $request->validate(
            [
                'regNumber' => 'required|numeric',
                'namaLengkap' => 'required',
                'jabatan_id' => 'required',
                'bidang_id' => 'required',
                'seksi_id' => 'required',
            ],
            [
                'regNumber.numeric' => 'Data NIP/NRHS harus berupa angka',
                'regNumber.required' => 'Data NIP/NRHS tidak boleh kosong',
                'jabatan_id.required' => 'Data jabatan pegawai tidak boleh kosong',
                'bidang_id.required' => 'Data bidang pegawai tidak boleh kosong',
                'seksi_id.required' => 'Data seksi pegawai tidak boleh kosong',
                'namaLengkap.required' => 'Data Nama Lengkap tidak boleh kosong',
            ]
        );

        $namaLengkap = $request->input('namaLengkap');
        $user = User::where('username', str_replace(' ', '_', strtolower($data_pegawai->namaLengkap)))->first();
        if($user)
        {
            $user->update([
                'username' => str_replace(' ', '_', strtolower($namaLengkap)),
            ]);
        }
        $data_pegawai->update($request->all());
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $data_pegawai)
    {
        $data_pegawai->delete();
        $username = str_replace(' ', '_', strtolower($data_pegawai->namaLengkap));
        User::deleteByUsername($username);
        return response()->json();
    }
}
