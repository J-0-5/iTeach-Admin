<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Parameter;
use App\ParameterValue;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{

    public function index(Request $request)
    {
        if ($request->teacher_id == 0) {
            $request['teacher_id'] = Auth::user()->id;
        }
        try {
            $schedule = Schedule::teacher($request->teacher_id)
                ->day($request->day)
                ->with('day', 'campus')
                ->get();

            return response()->json(['status' => true, 'message' => 'Consulta exitosa', 'data' => $schedule]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => null]);
        }
    }

    public function store(Request $request)
    {
        if ($request->teacher_id == 0) {
            $request['teacher_id'] = Auth::user()->id;
        }
        try {
            /*validate that all data exists in the database*/
            $role = ParameterValue::where('name', 'Profesor')->first();
            $day = Parameter::where('name', 'day')->first();
            $campus = Parameter::where('name', 'campus')->first();

            $Validator = Validator::make($request->all(), [
                'teacher_id' => ['required', Rule::exists('users', 'id')->where('role_id', $role->id)],
                'day' => ['required', Rule::exists('parameter_value', 'id')->where('parameter_id', $day->id)],
                'start_hour' => 'required|date_format:H:i',
                'final_hour' => 'required|date_format:H:i',
                'campus' => ['required', Rule::exists('parameter_value', 'id')->where('parameter_id', $campus->id)],
            ]);

            if ($Validator->fails()) {
                return response()
                    ->json([
                        'status' => false,
                        'message' => $Validator->errors()->first(),
                        'data' => null
                    ]);
            }
            /*===============================================*/

            /*subSecond to final_hour*/
            Arr::set($request, 'final_hour', Carbon::createFromFormat('H:i', $request->final_hour)->subSecond()->format('H:i'));
            /*===============================================*/

            /*validate that time range is correct*/
            $schedule = Schedule::where('day', $request->day)
                ->where('start_hour', '<=', $request->start_hour)
                ->where('final_hour', '>=', $request->start_hour)
                ->exists();

            if ($schedule) {
                return response()
                    ->json([
                        'status' => false,
                        'message' => 'La hora inicial se encuentra dentro del rango de un horario existente',
                        'data' => null
                    ]);
            }

            $schedule = Schedule::where('day', $request->day)
                ->where('start_hour', '<=', $request->final_hour)
                ->where('final_hour', '>=', $request->final_hour)
                ->exists();

            if ($schedule) {
                return response()

                    ->json([
                        'status' => false,
                        'message' => 'La hora final se encuentra dentro del rango de un horario existente',
                        'data' => null
                    ]);
            }

            $schedule = Schedule::where('day', $request->day)
                ->whereBetween('start_hour', [$request->start_hour, $request->final_hour])
                ->whereBetween('final_hour', [$request->start_hour, $request->final_hour])
                ->exists();
            if ($schedule) {
                return response()
                    ->json([
                        'status' => false,
                        'message' => 'Ya existe un horario dentro de este rango',
                        'data' => null
                    ]);
            }
            /*===============================================*/

            /*validate that the time is correct*/
            $start_hour = Carbon::createFromFormat('H:i', $request->start_hour);
            $final_hour = Carbon::createFromFormat('H:i', $request->final_hour);

            if ($start_hour->diffInMinutes($final_hour, false) < 0) {
                return response()
                    ->json([
                        'status' => false,
                        'message' => 'La hora final debe ser mayor que la hora inicial',
                        'data' => null
                    ]);
            }
            /*===============================================*/

            /*create schedule*/
            $schedule = Schedule::create($request->all());
            return response()
                ->json([
                    'status' => true,
                    'message' => 'Horario creado correctamente',
                    'data' => $schedule
                ]);
            /*===============================================*/
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'data' => null
                ]);
        }
    }

    public function delete($id)
    {
        try {
            Schedule::find($id)->delete();
            return response()->json(['status' => true, 'message' => 'Eliminación exitosa', 'data' => null]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => null]);
        }
    }
}
