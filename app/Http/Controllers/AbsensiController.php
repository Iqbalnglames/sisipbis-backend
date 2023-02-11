<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function showAbsen()
    {
        $absen = Absen::all();
        
        return response()->json($absen);
    }

    public function createAbsen(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'divisi' => 'required',
            'laporan' => 'required',
            'waktu_kehadiran' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $absen = Absen::create([
            'nama' => $request->nama,
            'divisi' => $request->divisi,
            'laporan' => $request->laporan,
            'waktu_kehadiran' => $request->waktu_kehadiran,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi Sukses!',
            'data'    => $absen
        ]);
    }

    public function showIzin()
    {
        $izin = Izin::all();
        
        return response()->json($izin);
    }

    public function createIzin(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'divisi' => 'required',
            'alasan' => 'required',
            'mulai_izin' => 'required',
            'akhir_izin' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $izin = Izin::create([
            'nama' => $request->nama,
            'divisi' => $request->divisi,
            'alasan' => $request->alasan,
            'mulai_izin' => $request->mulai_izin,
            'akhir_izin' => $request->akhir_izin,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Izin Sukses!',
            'data'    => $izin
        ]);
    }
}
