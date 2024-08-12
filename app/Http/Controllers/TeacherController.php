<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{

    function index()
    {
        $teachers = Teacher::paginate(15);
        return view('teacher', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'teacher_name' => 'required|max:50',
            'teacher_dob' => 'required|date',
            'teacher_doj' => 'required|date',
            'teacher_dol' => 'nullable|date',
            'teacher_gender' => 'required',

        ]);
        $validatedData['created_by'] = Auth::user()->id;
        Teacher::create($validatedData);
        return redirect()->back()->with('success', 'teacher added successfully!');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teachers = Teacher::all();
        return response()->json(['teacher' => $teacher, 'teachers' => $teachers]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'teacher_name' => 'required|max:50',
            'teacher_dob' => 'required|date',
            'teacher_doj' => 'required|date',
            'teacher_dol' => 'nullable|date',
            'teacher_gender' => 'required|integer',
        ]);

        $validatedData['updated_by'] = Auth::user()->id;
        $teachers = Teacher::findOrFail($id);
        $teachers->update($validatedData);
        // dd($teachers);
        return redirect()->back()->with('success', 'Teachers updated successfully!');
    }

    public function destroy($id)
    {
        $teachers = Teacher::findOrFail($id);
        $teachers->delete();
        return redirect()->back()->with('success', 'Teachers deleted successfully!');
    }
}
