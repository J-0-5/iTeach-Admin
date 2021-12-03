<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TutorshipShowResource;
use App\User, App\Teach, App\Schedule, App\Tutorship;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class TutorshipController extends Controller
{
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        $state = isset($request->state) ? $request->state : [];

        $tutorship = Tutorship::where('teacher_id', $id)
            ->orWhere('student_id', $id)
            ->state($state)
            ->with('getTeacher', 'getStudent', 'getSubjects', 'getSchedule')
            ->orderBy('date', 'ASC')
            ->get();

        $data = TutorshipShowResource::collection($tutorship);

        return response()->json([
            'status' => true,
            'message' => 'listado de tutorias',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request['date'] = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m-d');

            if ($request->student_id == 0) {
                $request['student_id'] = Auth::user()->id;
            }

            $validator = Validator::make($request->all(), [
                'teacher_id' => 'required|exists:users,id',
                'student_id' => 'required|exists:users,id',
                'subjects_id' => 'required|exists:subjects,id',
                'schedule_id' => ['required', 'exists:schedule,id', Rule::unique('tutorship')->where(function ($query) use ($request) {
                    return $query->where('date', $request->date);
                })],
                'date' => 'required|date|date_format:Y-m-d|after:today',
                'observation' => 'nullable'
            ], ['schedule_id.unique' => 'Ya hay una tutoría reservada para esta fecha y horario']);

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
            return response()->json(['status' => false, 'message' => "", 'data' => null], 200);
        }
    }

    public function show(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'tutorship_id' => 'required|exists:tutorship,id'
            ]);

            if ($validator->fails()) {
                return  response()->json(['status' => false, 'message' => $validator->errors()->first(), 'data' => $validator->errors()]);
            }

            $tutors = Tutorship::where('id', $request->tutorship_id)
                ->with('getTeacher', 'getStudent', 'getSubjects', 'getSchedule');

            $id = Auth::user()->id;

            if (Auth::user()->role_id == 2) {
                $tutors = $tutors->where('teacher_id', $id)->first();
            }

            if (Auth::user()->role_id == 3) {
                $tutors = $tutors->where('student_id', $id)->first();
            }

            if (!empty($tutors)) {

                $data = new TutorshipShowResource($tutors);

                return response()->json([
                    'status' => true,
                    'message' => 'Detalle de la tutoria',
                    'data' => $data
                ]);
            } else {
                return response()->json(['status' => false, 'message' => "Tutoria no disponible", 'data' => null]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => "", 'data' => null], 200);
        }
    }
}
