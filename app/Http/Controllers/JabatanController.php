<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));

        return view('admin.jabatan.index')->with([
            'name' => $nama,
            'title' => 'Data jabatan',
            'dataTitle' => 'Data Jabatan',
            'addData' => 'Tambah Jabatan',
            'editData' => 'Edit Jabatan',
            'jabatans' => Jabatan::all(),
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
        $request->validate([
                'namaJabatan' => 'required',
            ],
            [
                'namaJabatan.required' => 'Nama jabatan tidak boleh kosong',
            ]
        );

        $jabatan = Jabatan::create($request->all());

        $message = 'Data '. $jabatan->namaJabatan. ' Berhasil ditambahkan';
        return redirect()->route('data-jabatan.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $data_jabatan)
    {
        return response()->json($data_jabatan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $data_jabatan)
    {
        $request->validate([
                'namaJabatan' => 'required'
            ],
            [
                'namaJabatan.required' => 'Nama jabatan tidak boleh kosong',
            ]
        );

        $data_jabatan->update($request->all());
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $data_jabatan)
    {
        Pegawai::where('jabatan_id', $data_jabatan->id)->delete();
        $data_jabatan->delete();
        return response()->json();
    }
}
