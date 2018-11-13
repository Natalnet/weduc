<?php

namespace App\Http\Controllers\API;

use App\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json([
            'data' => [
                'classrooms' => Classroom::with('coach')->get()
            ]
        ]);
    }

    public function coaching()
    {
        $classrooms = auth()->user()->coachingClassrooms()->withCount('students')->get();

        return response()->json([
            'data' => [
                'classrooms' => $classrooms
            ]
        ]);
    }

    public function studying()
    {
        $classrooms = auth()->user()->classrooms()->with('coach')->get();

        return response()->json([
            'data' => [
                'classrooms' => $classrooms
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:classrooms,code'
        ]);

        $classroom = new Classroom();
        $classroom->coach_id = auth()->id();
        $classroom->code = $request->code;
        $classroom->save();

        return response()->json([
            'data' => $classroom
        ]);
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:classrooms,code'
        ], [
            'code.exists' => 'O código informado é inválido'
        ]);

        $classroom = Classroom::where('code', $request->code)->firstOrFail();
        $classroom->students()->syncWithoutDetaching(auth()->user());

        return response(null, 204);
    }
}
