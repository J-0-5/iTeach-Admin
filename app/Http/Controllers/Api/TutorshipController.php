<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User, App\Teach, App\Schedule, App\Tutorship;
use Carbon\Carbon;

class TutorshipController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request['date'] = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');
            // return response()->json(['status' => false, 'message' => "Estudiante no disponible", 'data' => $request->date]);
            if ($request->student_id == 0) {
                $request['student_id'] = Auth::user()->id;
            }

            $validator = Validator::make($request->all(), [
                'teacher_id' => 'required|exists:users,id',
                'student_id' => 'required|exists:users,id',
                'subjects_id' => 'required|exists:subjects,id',
                'schedule_id' => 'required|exists:schedule,id',
                'date' => 'required|date|date_format:Y-m-d|after:today',
                'observation' => 'nullable'
            ]);

            if ($validator->fails()) {
                return  response()->json(['status' => false, 'message' => $validator->errors()->first(), 'data' => $validator->errors()]);
            }

            $student = User::where('id', $request->student_id)->whereIn('role_id', [1, 3])->exists();
            if (!$student) {
                return response()->json(['status' => false, 'message' => "Estudiante no disponible", 'data' => null]);
            }

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
                } else {
                    return response()->json(['status' => false, 'message' => "Horario no disponible", 'data' => null]);
                }
            } else {
                return response()->json(['status' => false, 'message' => "El profesor no tiene la materia asignada", 'data' => null]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }
}
