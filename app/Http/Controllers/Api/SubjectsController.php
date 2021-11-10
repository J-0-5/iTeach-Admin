<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectsController extends Controller
{
    public function index()
    {
        $subjects = Subjects::get();
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
