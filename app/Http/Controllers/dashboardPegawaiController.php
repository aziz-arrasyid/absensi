<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardPegawaiController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now()->format('Y-m-d');

        $dataAbsensi = Absensi::where('tanggal', $currentDate)->pluck('id')->toArray();
        $dataAbsen = Absen::whereIn('absensi_id', $dataAbsensi)->get();

        $jumlahHadir = $dataAbsen->filter(function ($value, $key) {
            return data_get($value, 'status') === 'hadir';
        })->count();

        $jumlahIzin = $dataAbsen->filter(function ($value, $key) {
            return data_get($value, 'status') === 'izin';
        })->count();

        $jumlahSakit = $dataAbsen->filter(function ($value, $key) {
            return data_get($value, 'status') === 'sakit';
        })->count();

        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));

        return view('pegawai.index')->with([
            'name' => $nama,
            'title' => 'Dashboard pegawai',
            'dataAbsen' => $dataAbsen,
            'currentDate' => $currentDate,
            'jumlahHadir' => $jumlahHadir,
            'jumlahSakit' => $jumlahSakit,
            'jumlahIzin' => $jumlahIzin,
        ]);
    }


}
