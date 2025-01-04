<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        $dataUser = new User();
        $rules = [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'proses validasi gagal',
                'data'      => $validator->errors(),
            ], 401);
        }

        $dataUser->name = $request->name;
        $dataUser->email = $request->email;
        $dataUser->password = Hash::make($request->password);
        $dataUser->save();

        return response()->json([
            'status'    => true,
            'message'   => 'berhasil memasukan data baru',
        ], 200);
    }

    public function loginUser (Request $request){
        $rules = [
            'email'     => 'required|email',
            'password'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'proses Login gagal',
                'data'      => $validator->errors(),
            ], 401);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status' => false,
                'message'=> 'email dan password yang dimasukan tidak sesuai'
            ], 401);
        }

        $dataUser = User::where('email', $request->email)->first();
        return response()->json([
            'status' => true,
            'message'=> 'berhasil proses login',
            'token' =>$dataUser->createToken('api-token')->plainTextToken
        ]);
    }
}
