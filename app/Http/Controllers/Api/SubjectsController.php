<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectsResource;
use App\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SubjectsController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subjects::get();
        if ($request->unassigned == 1) {
            if ($request->teacher_id == 0) {
                $request['teacher_id'] = Auth::user()->id;
            }
            $teacher_id = $request->teacher_id;
            $subjects = Subjects::whereDoesntHave('teach', function (Builder $query) use ($teacher_id) {
                $query->where('teacher_id', $teacher_id);
            })->get();
        }

        $subjects = SubjectsResource::collection($subjects);
        return response()->json(['status' => true, 'message' => 'Materias existentes', 'data' => $subjects]);
    }

    public function store(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:subjects,name',
            ]);

            if ($Validator->fails()) {
                return  response()->json(['status' => false, 'message' => $Validator->errors()->first(), 'data' => $Validator->errors()]);
            }

            if (Subjects::create($request->all())) {
                return response()->json(['status' => true, 'message' => 'Materia creada correctamente', 'data' => null]);
            }
        } catch (\Exception $e) {
            return ($e);
            return response()->json(['status' => false, 'message' => "Hemos tenido problemas", 'data' => []], 200);
        }
    }

    public function update(Request $request)
    {
        try {
            $Validator = Validator::make($request->all(), [
                'id' => 'required|exists:subjects,id',
                'name' => 'required|string|unique:subjects,name',
            ]);

            if ($Validator->fails()) {
                return  response()->json(['status' => false, 'message' => $Validator->errors()->first(), 'data' => $Validator->errors()]);
            }

            if (Subjects::find($request->id)->update(['name' => $request->name])) {
                return response()->json(['status' => true, 'message' => 'Materia actualizada correctamente', 'data' => null]);
            }
        } catch (\Exception $e) {
            return ($e);
            return response()->json(['status' => false, 'message' => "Hemos tenido problemas", 'data' => []], 200);
        }
    }

    public function delete($id)
    {
        try {
            Subjects::find($id)->delete();
            return response()->json(['status' => true, 'message' => 'Eliminación exitosa', 'data' => null]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => null]);
        }
    }
}
