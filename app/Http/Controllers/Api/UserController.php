<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User, App\Teach, App\Schedule, App\Tutorship;
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
      if (is_null($request->id) || $request->id == 0) {
         $request['id'] = Auth::user()->id;
      }

      $userData = User::where('id', $request->id)
      ->with('role')
      ->first();

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

   public function addTutorship(Request $request)
   {
      try {
         if ($request->student_id == 0) {
            $request['student_id'] = Auth::user()->id;
         }

         $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
            'subjects_id' => 'required|exists:subjects,id',
            'schedule_id' => 'required|exists:schedule,id',
            'observation' => 'nullable'
         ]);

         if ($validator->fails()) {return  response()->json(['status' => false, 'message' => $validator->errors()->first(), 'data' => $validator->errors()]);}

         $student = User::where('id', $request->student_id)->whereIn('rol_id', [1, 3])->exists();
         if (!$student) {return response()->json(['status' => false, 'message' => "Estudiante no disponible", 'data' => null]);}

         $teach = Teach::where('teacher_id', $request->teacher_id)->where('subjects_id', $request->subjects_id)->exists();
         if ($teach) {
            $schedule = Schedule::where('id', $request->schedule_id)->where('teacher_id', $request->teacher_id)->exists();
            if ($schedule) {

               $tutorship = Tutorship::create($request->all());

               return response()->json([
                  'status' => true,
                  'message' => 'Tutoria asignada correctamente',
                  'data' => $tutorship
               ]);
            }else{
               return response()->json(['status' => false, 'message' => "Horario no disponible", 'data' => null]);
            }
         }else{
            return response()->json(['status' => false, 'message' => "El profesor no tiene la materia asignada", 'data' => null]);
         }
      } catch (\Exception $e) {
         dd($e);
         return response()->json(['status' => false, 'message' => "", 'data' => null], 200);
      }
   }
}
