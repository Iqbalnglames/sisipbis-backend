<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengaduanController extends Controller
{
    public function showPengaduan()
    {
        $pengaduan = Pengaduan::all();
        
        return response()->json($pengaduan);
    }

    public function createPengaduan(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_pelapor' => 'required',
            'divisi' => 'required',
            'laporan' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pengaduan = Pengaduan::create([
            'nama_pelapor' => $request->nama_pelapor,
            'divisi' => $request->divisi,
            'laporan' => $request->laporan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan Sukses Terkirim!',
            'data'    => $pengaduan
        ]);
    }

    public function updatePengaduan(Request $request, Pengaduan $UpdatePengaduan)
    {
        $validator = Validator::make($request->all(),[
            'status_laporan' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $UpdatePengaduan->update([
           
            'status_laporan' => $request->status_laporan,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Pengaduan Sukses Terkirim!',
            'data'    => $UpdatePengaduan
        ]);

    }

    public function showDetailPengaduan($id)
    {
        $pengaduan = Pengaduan::find($id);
        return response()->json($pengaduan);
    }
}
