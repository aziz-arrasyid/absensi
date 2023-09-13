<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));
        $Pegawai = Pegawai::where('namaLengkap', $nama)->first();

        $absensi = Absensi::all();

        $absen = Absen::where('pegawai_id', $Pegawai->id)->whereIn('absensi_id', $absensi->pluck('id'))->get();

        return view('pegawai.absen.index')->with([
            'title' => 'Data absen',
            'name' => $nama,
            'dataTitle' => 'Data Absen',
            'addData' => 'Tambah Absen',
            'editData' => 'isi Absen',
            'Absen' => $absen,
            'Absensi' => Absensi::all(),
            'Pegawai' => $Pegawai,
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
                'latitude' => 'required',
                'longitude' => 'required',
                'photo' => 'required|image',
            ],
            [
                'latitude.required' => 'tidak bisa mendapatkan latitude',
                'longitude.required' => 'tidak bisa mendapatkan longitude',
                'photo.required' => 'foto tidak boleh kosong',
                'photo.image' => 'Harap unggah file adalah foto',
            ]
        );
        $gambar = $request->file('photo');
        $namaFoto = uniqid() . '_' . time() . '.jpg';
        $request->file('photo')->storeAs('public/photos', $namaFoto);
        // $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $gambar));
        // $namaFoto = uniqid(). '.jpeg';
        // file_put_contents(storage_path('app/public/photos/' . $namaFoto), $imageData);
        // Storage::put('public/photos/' . $namaFoto, $imageData);

        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));
        $pegawai = Pegawai::where('namaLengkap', $nama)->first();

        Absen::create([
            'pegawai_id' => $pegawai->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'absensi_id' => $request->absensi_id,
            'photo' => $namaFoto,
        ]);

        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(Absen $absen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absen $absen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absen $data_absen)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $data_absen->update($request->all());

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absen $absen)
    {
        //
    }
}
