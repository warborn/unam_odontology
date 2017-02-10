<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Course;
use App\Teacher;
use App\Student;
use App\Movement;

class TeachersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:teachers');
        $this->middleware('check.clinic:course', ['only' => ['show_course', 'update_student_status']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
