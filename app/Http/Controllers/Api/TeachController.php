<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeachGetSubjectsResource;
use App\Http\Resources\TeachGetTeachersResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User, App\Teach;

class TeachController extends Controller
{
    public function subject(Request $request)
    {
        try {
            if ($request->teacher_id == 0) {
                $request['teacher_id'] = Auth::user()->id;
            }

            $teacher = Teach::with('getUsers', 'getSubjects')
                ->teach($request->teacher_id)
                ->subject($request->subjects_id)
                ->get();

            !empty($request->teacher_id)
                ? $data = TeachGetSubjectsResource::collection($teacher)
                : $data = TeachGetTeachersResource::collection($teacher);

            return response()->json(['status' => true, 'message' => "Listado", 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "", 'data' => null], 200);
        }
    }

    public function assign(Request $request)
    {
        try {
            if ($request->teacher_id == 0) {
                $request['teacher_id'] = Auth::user()->id;
            }

            $validator = Validator::make($request->all(), [
                'teacher_id' => 'required|exists:users,id',
                'subjects_id' => 'required|exists:subjects,id',
            ]);

            if ($validator->fails()) {
                return  response()->json(['status' => false, 'message' => $validator->errors()->first(), 'data' => $validator->errors()]);
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

    public function deleteAssign(Request $request)
    {
        try {
            if (is_null($request->teacher_id) || $request->teacher_id == 0) {
                $request['teacher_id'] = Auth::user()->id;
            }

            $validator = Validator::make($request->all(), [
                'teacher_id' => 'required|exists:users,id',
                'subjects_id' => 'required|exists:subjects,id',
            ]);

            if ($validator->fails()) {
                return  response()->json(['status' => false, 'message' => $validator->errors()->first(), 'data' => $validator->errors()]);
            }

            $deletedRows = Teach::where('teacher_id', $request->teacher_id)
                ->where('subjects_id', $request->subjects_id)
                ->delete();

            return response()->json(['status' => true, 'message' => "Asignación eliminada correctamente", 'data' => null], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "", 'data' => null], 200);
        }
    }
}
