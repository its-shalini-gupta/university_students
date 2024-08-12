<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    function index()
    {
        $students = Student::paginate(15);
        $teachers = Teacher::all();
        return view('student', compact('students', 'teachers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'student_name' => 'required|max:50',
            'student_dob' => 'required|date',
            'student_admission_date' => 'required|date',
            'student_dol' => 'nullable|date',
            'student_class' => 'required|max:50',
            'student_teacher_id' => 'required|exists:teachers,teacher_id',
            'student_yearly_fees' => 'required|numeric',
            'student_gender' => 'required',

        ]);

        $validatedData['created_by'] = Auth::user()->id;

        // Create a new student record in the database
        Student::create($validatedData);


        return redirect()->back()->with('success', 'Student added successfully!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $teachers = Teacher::all();
        return response()->json(['student' => $student, 'teachers' => $teachers]);
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'student_name' => 'required|max:50',
            'student_dob' => 'required|date',
            'student_admission_date' => 'required|date',
            'student_dol' => 'nullable|date',
            'student_class' => 'required|max:50',
            'student_teacher_id' => 'required|exists:teachers,teacher_id',
            'student_yearly_fees' => 'required|numeric',
            'student_gender' => 'required|integer',
        ]);

        $validatedData['updated_by'] = Auth::user()->id;
        $student = Student::findOrFail($id);
        $student->update($validatedData);
        // dd($student);
    
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }
    
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
    
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
    
}
