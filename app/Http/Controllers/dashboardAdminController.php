<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class dashboardAdminController extends Controller
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

        return view('admin.index')->with([
            'name' => $nama,
            'title' => 'Dashboard admin',
            'dataAbsen' => $dataAbsen,
            'currentDate' => $currentDate,
            'jumlahHadir' => $jumlahHadir,
            'jumlahSakit' => $jumlahSakit,
            'jumlahIzin' => $jumlahIzin,
        ]);
    }

    public function show($id)
    {
        $absenData = Absen::with('pegawai')->where('absensi_id', $id)->get();
        return response()->json($absenData);
    }

    public function rekap()
    {
        $Absensi = Absensi::all();

        $groupAbsensi = $Absensi->groupBy(function($item) {
            return $item->tanggal;
        });

        $uniqueAbsensi = $groupAbsensi->map(function ($group) {
            return $group->first();
        });

        //tahun
        $groupAbsensiTahun = $Absensi->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('Y');
        });

        $AbsensiTahun = $groupAbsensiTahun->map(function ($group) {
            return $group->first();
        });

        //bulan
        $groupAbsensiBulan = $Absensi->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('F');
        });

        $AbsensiBulan = $groupAbsensiBulan->map(function ($group) {
            return $group->first();
        });

        $nama = str_replace('_', ' ', strtolower(Auth::user()->username));

        return view('admin.rekap.index')->with([
            'name' => $nama,
            'title' => 'Data rekap',
            'rekap' => 'Rekap data',
            'Absensi' => $uniqueAbsensi,
            'AbsensiTahun' => $AbsensiTahun,
            'AbsensiBulan' => $AbsensiBulan,
            'dataTitle' => 'Data absensi untuk rekap',
        ]);
    }

    public function generateOnePDF($tanggal)
    {
        $dataAbsensi = Absensi::where('tanggal', $tanggal)->pluck('id')->toArray();

        $dataAbsen = Absen::whereIn('absensi_id', $dataAbsensi)->get();

        $PDF = Pdf::loadView('layouts.pdfTemplate', [
            'data' => $dataAbsen,
            'tanggal' => $tanggal,
        ]);

        $fileName = 'data_'.$tanggal;
        return $PDF->download($fileName.'.pdf');
        // dd($data, $dataAbsen);
    }

    public function generateOneMonthPDF($tahun, $bulan)
    {
        try {
            $Absensi = Absensi::whereYear('tanggal', $tahun)->whereMonth('tanggal', Carbon::parse($bulan)->month)->pluck('id')->toArray();

            $Absen = Absen::whereIn('absensi_id', $Absensi)->get();

            $PDF = Pdf::loadView('layouts.pdfTemplate', [
                'data' => $Absen,
                'tanggal' => $bulan . ' ' . $tahun,
            ]);

            $fileName = 'data_' . $bulan . '_' . $tahun;
            return $PDF->download($fileName . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'pilih tahun dan bulan terlebih dahulu untuk rekap absensi/bulan');
        }
    }

    public function filterData(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $Absensi = Absensi::whereYear('tanggal', $tahun)->whereMonth('tanggal', Carbon::parse($bulan)->month)->get();

        $uniqueAbsensi = $Absensi->map(function ($group) {
            return $group->first();
        });

        return response()->json($Absensi);
    }

    public function pdf()
    {
        return view('layouts.pdfTemplate');
    }

}
