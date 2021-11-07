<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function Login(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($Validator->fails()) {
            return  response()->json(['status' => false, 'message' => $Validator->errors()->first(), 'data' => $Validator->errors()]);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return  response()->json(['status' => false, 'message' => 'Credenciales incorrectas', 'data' => null]);
        }

        $token = Auth::user()->createToken('authToken')->plainTextToken;

        return  response()->json(['status' => true, 'message' => 'Sesión iniciada', 'data' => $token]);
    }
}
