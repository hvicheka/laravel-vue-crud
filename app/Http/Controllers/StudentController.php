<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class StudentController extends Controller
{
    public function index(){
        $students = Student::paginate(10);
        return response()->json($students);
    }

    public function saveStudent(){
        $student = new Student();
        $student->name = request()->name;
        $student->email = request()->email;
        $student->phone = request()->phone;

        $student->save();
    }

    public function editStudent($id){
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function updateStudent(){
        $student = Student::findOrFail(request()->id);
        $student->name = request()->name;
        $student->email = request()->email;
        $student->phone = request()->phone;

        $student->update();
    }

    public function showDelete($id){
        return $id;
    }

    public function deleteStudent($id){
        $student = Student::findOrFail($id)->delete();
    }
}
