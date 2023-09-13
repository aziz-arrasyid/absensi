<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));
        return view('admin.absensi.index')->with([
            'name' => $nama,
            'title' => 'Data absensi',
            'dataTitle' => 'Data Absensi',
            'addData' => 'Add Absensi',
            'editData' => 'Edit Absensi',
            'Absensi' => Absensi::all(),
            'Absen' => Absen::all(),
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
                'waktu' => 'required',
                'tanggal' => 'required',
            ],
            [
                'waktu.required'=> 'Data waktu tidak boleh kosong',
                'tanggal.required'=> 'Data tanggal tidak boleh kosong',
            ]
        );

        $absensi = Absensi::create($request->all());
        $message = 'Data pada tanggal '. $absensi->tanggal. ' pada '. $absensi->waktu. ' hari';
        return redirect()->route('data-absensi.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $data_absensi)
    {
        return response()->json($data_absensi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $data_absensi)
    {
        $request->validate(
            [
                'waktu' => 'required',
                'tanggal' => 'required',
            ],
            [
                'waktu.required' => 'Data waktu tidak boleh kosong',
                'tanggal.required' => 'Data tanggal tidak boleh kosong',
            ]
        );

        $data_absensi->update($request->all());
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $data_absensi)
    {
        $data_absensi->delete();
        return response()->json();
    }
}
