<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return response()->json($students, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastname' => 'required',
            'age' => 'required',
            'career' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la recoleccion de datos',
                'errors' => $validator->errors()
            ];
            return response()->json($data);
        }

        $student = Student::create([
            'id' => $request->id,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'age' => $request->age,
            'career' => $request->career
        ]);

        $data = [
            'message' => 'Estudiante creado exitosamente',
            'student' => $student
        ];

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado'
            ];
            return response()->json($data, 404);
        }

        return response()->json($student, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student  = Student::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lastname' => 'required',
            'age' => 'required',
            'career' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors()
            ];
            return response()->json($data);
        }

        $student->name = $request->name;
        $student->lastname = $request->lastname;
        $student->age = $request->age;
        $student->career = $request->career;

        $data = [
            'message' => 'Estudiante actualizado correctamente',
            'estudiante' => $student
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado'
            ];
            return response()->json($data, 404);
        }

        $student->delete();
        $data = [
            'message' => 'Estudiante eliminado correctamente'
        ];
        return response()->json($data, 200);
    }
}
