<?php

namespace App\Http\Controllers;

use App\Models\Seksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));

        return view('admin.seksi.index')->with([
            'name' => $nama,
            'title' => 'Data seksi',
            'dataTitle' => 'Data Seksi',
            'addData' => 'Tambah Seksi',
            'editData' => 'Edit Seksi',
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
        $request->validate([
                'namaSeksi' => 'required',
            ],
            [
                'namaSeksi.required' => 'Data seksi tidak boleh kosong',
            ]
        );

        $seksi = Seksi::create($request->all());

        $message = 'Data ' . $seksi->namaSeksi . ' Berhasil ditambahkan';
        return redirect()->route('data-seksi.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Seksi $seksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seksi $data_seksi)
    {
        return response()->json($data_seksi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seksi $data_seksi)
    {
        $request->validate(
            [
                'namaSeksi' => 'required',
            ],
            [
                'namaSeksi.required' => 'Data seksi tidak boleh kosong',
            ]
        );

        $data_seksi->update($request->all());

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seksi $data_seksi)
    {
        $data_seksi->delete();
        return response()->json();
    }
}
