<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));

        return view('admin.bidang.index')->with([
            'name' => $nama,
            'title' => 'Data bidang',
            'dataTitle' => 'Data Bidang',
            'addData' => 'Tambah Bidang',
            'editData' => 'Edit Bidang',
            'bidangs' => Bidang::all()
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
            'namaBidang' => 'required'
            ],
            [
                'namaBidang.required' => 'Data Bidang tidak boleh kosong'
            ]
        );

        $bidang = Bidang::create($request->all());

        $message = 'Data ' . $bidang->namaBidang . ' Berhasil ditambahkan';
        return redirect()->route('data-bidang.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bidang $bidang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $data_bidang)
    {
        return response()->json($data_bidang);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidang $data_bidang)
    {
        $request->validate(
            [
                'namaBidang' => 'required'
            ],
            [
                'namaBidang.required' => 'Data Bidang tidak boleh kosong'
            ]
        );

        $data_bidang->update($request->all());
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $data_bidang)
    {
        $data_bidang->delete();
        return response()->json();
    }
}
