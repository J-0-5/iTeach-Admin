<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Parameter;
use App\ParameterValue;
use Illuminate\Http\Request;

class ParameterValueController extends Controller
{
    public function index(Request $request)
    {
        $parameter = Parameter::where('name', $request->name)->first();
        if (is_null($parameter)) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Parametro ' . $request->name . ' no encontrado',
                    'data' => null
                ]);
        }

        $parameterValue = ParameterValue::where('parameter_id', $parameter->id)->get();
        return response()
            ->json([
                'status' => true,
                'message' => 'Valores del parametro ' . $request->name,
                'data' => $parameterValue
            ]);
    }
}
