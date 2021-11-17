<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Login(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
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

    public function show(Request $request)
    {
        if(is_null($request->id)){
            $request['id'] = Auth::user()->id;
        }

        $userData = User::find($request->id);
        if (!empty($userData)) {
            return response()->json(['status' => true, 'message' => "Datos del usuario", 'data' => $userData], 200);
        } else {
            return response()->json(['status' => false, 'message' => "Usuario no disponible", 'data' => []], 200);
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
                'first_name' => 'required',
                'second_name' => 'nullable',
                'first_last_name' => 'required',
                'second_last_name' => 'nullable',
                'photo' => 'nullable|file',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                $message = $validator->errors()->first();
                return response()->json(['state' => false, 'message' => $message, 'data' => []], 200);
            }

            $photUrl = "null";
            if ($request->hasFile('photo')) {
                $photUrl = $request->file('photo')->store(
                    'photo',
                    'public'
                );
            }

            $userData = User::find($request->id);
            $userData->first_name = $request->first_name;
            $userData->second_name = $request->second_name;
            $userData->first_last_name = $request->first_last_name;
            $userData->second_last_name = $request->second_last_name;
            if ($request->hasFile('photo')) {
                $userData->photo_url = $photUrl;
            }
            if (!empty($request->password)) {
                $userData->password = Hash::make($request->password);
            }
            $userData->update();

            return response()->json(['status' => true, 'message' => "Usuario actualizado correctamente", 'data' => $userData], 200);
        } catch (\Exception $e) {
            return ($e);
            return response()->json(['status' => false, 'message' => "Hemos tenido problemas", 'data' => []], 200);
        }
    }
}
