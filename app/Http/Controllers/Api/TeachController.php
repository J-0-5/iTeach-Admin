<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeachGetSubjectsResource;
use App\Http\Resources\TeachGetTeachersResource;
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
}
