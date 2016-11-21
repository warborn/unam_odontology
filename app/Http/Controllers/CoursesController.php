<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Group;
use App\Period;
use App\Subject;
use App\Course;
use App\Teacher;
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
        try{
            $this->makeValidation($request);

        }catch(\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'No se pudo crear el grupo error:'.$e->getCode());
            return redirect('courses/create');
        }
            session()->flash('success', 'El curso fue creado correctamente.');
            return redirect('courses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $teachers = Teacher::with('personal_information')->get();
        $courses = Course::with('teachers')->with('period')->with('group')->with('subject')->find($course->course_id);
        return View('courses/show')->with('course', $courses)->with('teachers', $teachers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course)
    {
        $groups = Group::pluck('group_id', 'group_id');
        $periods = Period::pluck('period_id', 'period_id');
        $subjects = Subject::pluck('subject_name','subject_id');
        $course = Course::find($course);
        return View('courses/edit')->with('course', $course)->with('groups', $groups)->with('periods', $periods)->with('subjects', $subjects);
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
        try{
            $this->makeValidation($request, $course);
        }catch(\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'El curso no se pudo modificar');
            return redirect('courses');
        }
            session()->flash('info', 'Se modifico el curso: '.$course->course_id);
            return redirect('courses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();
            }catch (\Illuminate\Database\QueryException $e){
                session()->flash('warning', 'El curso no se puede eliminar');
                return redirect('courses');
            }
            session()->flash('danger', 'El curso fue eliminado correctamente.');
            return redirect('courses');        
    }

    public function store_teacher(Request $request, Course $course){
            $teacher = Teacher::findOrFail($request->teacher_id);
            $course = Course::findOrFail($request->course_id);
            $values = ['teacher_id'=>$request->teacher_id,
                        'course_id'=>$request->course_id
                        ];
            $resource = new CourseTeacher($values);
        try{
            $resource->save();
        }catch(\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'No se pudo crear la relacion curso-profesor');
            return redirect()->action('CoursesController@show', ['course'=>$request->course_id]);
        }
            session()->flash('success', 'Se creo la relacion curso-profesor de manera correcta');
            return redirect()->action('CoursesController@show', ['course'=>$request->course_id]);
    }

    public function delete_teacher(Course $course, Teacher $teacher)
    {
        try {
            $course->delete();
            }catch (\Illuminate\Database\QueryException $e){
                session()->flash('warning', 'La relacion curso-profesor no se puede eliminar');
                return redirect('courses');
            }
            session()->flash('danger', 'La relacion curso-profesor fue eliminada correctamente.');
            return redirect('courses');        
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
            $resource->update($values);
            $resource->generatePk();
            return $resource->update($values);
        } else {
            $resource = new Course($values);
            $resource->generatePK();
            return $resource->save();
        }
    }
}
