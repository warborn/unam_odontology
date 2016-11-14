<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Group;
use App\Period;
use App\Subject;
use App\Course;
use App\Http\Requests;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('group')->with('period')->with('subject')->get();
        return View('courses.index')->with('courses',$courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::pluck('group_id', 'group_id');
        $periods = Period::pluck('period_id', 'period_id');
        $subjects = Subject::pluck('subject_name','subject_id');

        return View('courses.create')->with('groups', $groups)->with('periods', $periods)->with('subjects', $subjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->makeValidation($request)) {
            return redirect('courses');
        } else {
            return redirect('courses/create');
        }
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
    public function update(Request $request, Course $course)
    {
        return $this->makeValidation($request, $course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->back();
    }

    private function makeValidation(Request $request, $resource = null) 
    {
        $group = Group::findOrFail($request->group_id);
        $subject = Subject::findOrFail($request->subject_id);
        $period = Period::findOrFail($request->period_id);

        $values = ['subject_id' => $request->subject_id, 
                   'group_id' => $request->group_id, 
                   'period_id' => $request->period_id];

        if(isset($resource)) {
            return $resource->update($values);
        } else {
            $resource = new Course($values);
            $resource->generatePK();
            return $resource->save();
        }
    }
}
