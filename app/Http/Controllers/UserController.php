<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'divisi'      => 'required',
            'email'      => 'required|email',
            'username'     => 'required|unique:users',
            'password'  => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user_photo = $request->file('user_photo');
        $user_photo -> storeAs('public/user_photo', $user_photo->hashName());
        $user = User::create([
            'user_photo' => $user_photo->hashName(),
            'nama'      => $request->nama,
            'email'      => $request->email,
            'divisi'      => $request->divisi,  
            'username'     => $request->username,
            'password'  => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register Sukses!',
            'data'    => $user  
        ]);
    }

    public function login (Request $request)
    {
        $validator = Validator::make($request -> all(),
        [
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $user = User::where('username',$request->username)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
            'success' => false,
            'message' => 'Password atau Username Salah',
        ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $user,
            'token' => $user->createToken('authToken')->accessToken,
        ]);

    }
    
    public function logout(Request $request)
    {
            $removeToken = $request->user()->tokens()->delete();
    }

    public function index()
    {
            $dataUser = User::where('role_id', 2)->get();
            return response()->json($dataUser);
    }

    public function show($id)
    {
        $dataUser = User::find($id);
        return response()->json($dataUser);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'divisi'      => 'required',
            'email'      => 'required|email',
            'username'     => 'required|unique:users',
            'password'  => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($request->hasFile('user_photo')){

            $user_photo = $request->file('user_photo');
            $user_photo -> storeAs('public/user_photo', $user_photo->hashName());
            
            
            $user->update([
                File::delete('public/user_photo' .$user->user_photo),
                'user_photo' => $user_photo->hashName(),
                'nama'      => $request->nama,
                'email'      => $request->email,
                'divisi'      => $request->divisi,
                'username'     => $request->username,
                'password'  => Hash::make($request->password),
            ]);
        }else{
            $user->update([
                'nama'      => $request->nama,
                'email'      => $request->email,
                'divisi'      => $request->divisi,
                'username'     => $request->username,
                'password'  => Hash::make($request->password),
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Update Success!',
            'data'    => $user
        ]);
    }

    public function delete($id)
    {
        $deleted = DB::table('users')->delete($id);
    }
}

