<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Group;
use App\Period;
use App\Subject;
use App\Course;
use App\Teacher;
use App\Clinic;
use App\Account;
use App\Role;
use App\Http\Requests;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('course', ['except' => ['index', 'create', 'store']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::fromClinic(clinic())->with('group')->with('period')->with('subject')->Paginate(10);
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

        } catch(\Illuminate\Database\QueryException $e){
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
        $users = Account::activated()->fromClinic(clinic())->get()->map(function($account) {
            return [$account->user_id => $account->user->personal_information->fullname()];
        })->flatten(1);

        $users = $users->diffKeys($course->teachers->map(function($teacher) {
            return [$teacher->user_id => $teacher->personal_information->fullname()];
        })->flatten(1));

        $course->load('teachers.personal_information')->load('period')->load('group')->load('subject');
        return View('courses.show')->with('course', $course)->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $groups = Group::pluck('group_id', 'group_id');
        $periods = Period::pluck('period_id', 'period_id');
        $subjects = Subject::pluck('subject_name','subject_id');
        // $course = Course::fromClinic(clinic())->find($course);
        return View('courses.edit')->with('course', $course)->with('groups', $groups)->with('periods', $periods)->with('subjects', $subjects);
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
        } catch(\Illuminate\Database\QueryException $e){
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
        } catch (\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'El curso no se puede eliminar');
            return redirect('courses');
        }
        session()->flash('danger', 'El curso fue eliminado correctamente.');
        return redirect('courses');        
    }

    public function store_teacher(Request $request, Course $course)
    {
        $account = Account::from($request->user_id, clinic()->clinic_id);

        if(isset($account)) {
            if(!$account->has_role('teacher')) {
                $account->roles()->attach(Role::name('teacher')->role_id); // translate later
            }
            if(!$account->has_profile('teacher')) {
                $account->assign_type('teacher');
            }

            $course->teachers()->attach($account->user_id);
            session()->flash('success', 'El profesor fue asignado correctamente.');
        } else {
            session()->flash('danger', 'Hubo un error al asignar al profesor.');
        }
        return redirect()->back();
    }

    public function destroy_teacher(Course $course, Teacher $teacher)
    {
        $course->teachers()->detach($teacher->user_id);
        session()->flash('success', 'El profesor fue eliminado correctamente.');
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
            $resource->update($values);
            $resource->generatePk();
            return $resource->update($values);
        } else {
            $resource = new Course($values);
            $resource->generatePK();
            $resource->clinic_id = Clinic::first()->clinic_id;
            return $resource->save();
        }
    }
}
