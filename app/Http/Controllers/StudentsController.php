<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Course;
use App\Student;
use App\Movement;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:students');
        $this->middleware('check.clinic:course', ['except' => ['index_courses', 'index_accepted_courses']]);
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
    public function show($id)
    {
        //
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
        $student = Auth::user()->student;

        $courses = Course::fromClinic(clinic())->with('students')->get();
        return View('students.index_courses')->with('courses', $courses)
            ->with('student', $student);
    }

    public function index_accepted_courses(Student $student) {
        return response()->json($student->courses()->fromClinic(clinic())->where('status', 'accepted')->get()->load('subject'));
    }

    public function store_course(Course $course) {
        $student = Auth::user()->student;
        if(!$course->has_student($student)) {            
            $course->students()->attach($student->user_id);
            Movement::register(account(), null, 'students.store_course');
        }
        return redirect()->back();
    }

    public function destroy_course(Course $course) {
        $student = Auth::user()->student;
        if($course->has_student($student)) {
            $course->students()->detach($student->user_id);
            Movement::register(account(), null, 'students.destroy_course');
        }
        return redirect()->back();
    }
}
