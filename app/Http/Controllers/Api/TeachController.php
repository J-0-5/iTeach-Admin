<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeachGetSubjectsResource;
use App\Http\Resources\TeachGetTeachersResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User, App\Teach;

class TeachController extends Controller
{
   public function subject(Request $requets)
   {
      try {
         //$teach = User::where('id', $requets->id)->where('rol_id', 2)->first();
         $teacher = Teach::with('getUsers', 'getSubjects')
         ->teach($requets->teacher_id)
         ->subject($requets->subjects_id)
         ->get();

         if (!empty($requets->teacher_id)) {$data = TeachGetSubjectsResource::collection($teacher);
         }else{$data = TeachGetTeachersResource::collection($teacher);}

         return response()->json(['status' => true, 'message' => "Listado", 'data' => $data], 200);
      } catch (\Exception $e) {
         return response()->json(['status' => false, 'message' => "", 'data' => null], 200);
      }
   }

   public function assign(Request $request)
   {
      try {
         $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|string|exists:users,id',
            'subjects_id' => 'required|string|exists:subjects,id',
         ]);

         if ($validator->fails()) {
            return  response()->json(['status' => false, 'message' => $Validator->errors()->first(), 'data' => $Validator->errors()]);
         }

         Teach::updateOrCreate(
            ['teacher_id' => $request->teacher_id, 'subjects_id' => $request->subjects_id],
            []
         );

         return response()->json(['status' => true, 'message' => "Materia asignada correctamente", 'data' => null], 200);
      } catch (\Exception $e) {
         return response()->json(['status' => false, 'message' => "", 'data' => null], 200);
      }

   }
}
