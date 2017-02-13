<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Course;
use App\Teacher;
use App\Student;
use App\Movement;
use Validator;

class TeachersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:teachers', ['except' => 'update']);
        $this->middleware('check.clinic:course', ['except' => ['update', 'index_courses']]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_course(Course $course)
    {
        $course = $course->load('students');
        return View('teachers.show_course')->with('course', $course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validator = Validator::make($request->all(), [
            'rfc' => 'required|max:14',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $values = [
            'rfc' => $request->rfc,
        ];

        $teacher->update($values);
        session()->flash('success', 'Se ha actualizado la información exitosamente.');
        return redirect()->back();
    }

    public function index_courses() {
        $teacher = Auth::user()->teacher;
        return View('teachers.index_courses')->with('courses',$teacher->courses);
    }

    public function update_student_status(Request $request, Course $course, Student $student) {
        if($request->status == 'accepted' || $request->status == 'rejected') {
            if($course->has_student($student)) {            
                $course->students()->updateExistingPivot($student->user_id, ['status' => $request->status]);
                // Movement::register(account(), $student->account(clinic()), 'teachers.update_student_status');
            }
        }
        return redirect()->back();
    }
}
