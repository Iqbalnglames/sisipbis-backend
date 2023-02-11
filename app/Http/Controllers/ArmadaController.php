<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ArmadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomer_armada' => 'required',
            'nama_chasis' => 'required',
            'status' => 'required',
            'catatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        };

        $gambar_armada = $request->file('armada_picture_name');
        $gambar_armada -> storeAs('public/foto_armada', $gambar_armada->hashName());

        $Maintenance = Maintenance::create([
            'armada_picture_name' => $gambar_armada->hashName(),
            'nomer_armada' => $request->nomer_armada,
            'nama_chasis' => $request->nama_chasis,
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register Success!',
            'data' => $Maintenance
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maintenance $armada)
    {
        $validator = Validator::make($request->all(), [
            'nomer_armada' => 'required',
            'nama_chasis' => 'required',
            'status' => 'required',
            'catatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($request->hasFile('armada_picture_name')){

            $gambar_armada = $request->file('armada_picture_name');
            $gambar_armada -> storeAs('public/foto_armada', $gambar_armada->hashName());
            
            $armada->update([
                File::delete('public/foto_armada' .$armada->armada_picture_name),
                'armada_picture_name' => $gambar_armada->hashName(),
                'nomer_armada' => $request->nomer_armada,
                'nama_chasis' => $request->nama_chasis,
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]);
        }else{
            $armada->update([
                'nomer_armada' => $request->nomer_armada,
                'nama_chasis' => $request->nama_chasis,
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Update Success!',
            'data'    => $armada
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = DB::table('maintenances')->delete($id);
    }
}
