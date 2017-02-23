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
use App\Movement;
use App\Http\Requests;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:courses');
        $this->middleware('check.clinic:course', ['except' => ['index', 'create', 'store']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get current page form url e.g. &page=6
        // $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // // Define how many items we want to be visible in each page
        // $perPage = 20;

        $courses = Course::fromClinic(clinic())->orderBy('period_id', 'DESC')->orderBy('subject_id', 'DESC')->with('group')->with('period')->with('subject')->withCount('students')->with('teachers')->customPaginate(20, $request);

        // Create our paginator and pass it to the view
        // $courses = new LengthAwarePaginator($courses, Course::count(), $perPage);
        // $courses->setPath($request->url());
        // $courses->appends($request->except(['page']));

        return View('courses.index')->with('courses', $courses);
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
        if($this->valid_data($request)) {
            if(!Course::fromClinic(clinic())->withData($request)->exists()) {
                $this->saveResource($request);
                Movement::register(account(), null, 'courses.store'); // update course
                session()->flash('success', 'El curso se creo correctamente');
                return redirect('courses');
            } else {
                session()->flash('warning', 'Ya existe un curso con esos datos');
            }
        } else {
            session()->flash('warning', 'No se pudo crear el curso');
        }

        return redirect()->back()->withInput($request->all());
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
        if($this->valid_data($request)) {
            if(!Course::fromClinic(clinic())->withData($request)->where('course_id', '<>', $course->course_id)->exists()) {
                $this->saveResource($request, $course);
                Movement::register(account(), null, 'courses.update'); // update course
                session()->flash('success', 'Se modifico el curso exitosamente');
                return redirect('courses');
            } else {
                session()->flash('warning', 'Ya existe un curso con esos datos');
            }
        } else {
            session()->flash('warning', 'No se pudo crear el curso');
        }

        return redirect()->back();
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
            Movement::register(account(), null, 'courses.destroy'); // destroy course
            session()->flash('success', 'El curso fue eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'El curso no se puede eliminar');
            return redirect('courses');
        }
        return redirect('courses');        
    }

    public function store_teacher(Request $request, Course $course)
    {
        $account = Account::from($request->user_id, clinic()->clinic_id);

        if(isset($account)) {
            if(!$account->has_role('teacher')) {
                $account->roles()->attach(config('id.teacher')); // translate later
            }
            if(!$account->has_profile('teacher')) {
                $account->assign_profile('teacher');
            }
            if(!$course->have_teacher($account)) {
                $course->teachers()->attach($account->user_id);
                Movement::register(account(), $account, 'courses.store_teacher'); // store teacher
                session()->flash('success', 'El profesor fue asignado correctamente.');
            }
        } else {
            session()->flash('danger', 'Hubo un error al asignar al profesor.');
        }
        return redirect()->back();
    }

    public function destroy_teacher(Course $course, Teacher $teacher)
    {
        if($course->have_teacher($teacher)) {
            $course->teachers()->detach($teacher->user_id);
            Movement::register(account(), $teacher->account(clinic()), 'courses.destroy_teacher'); // store teacher
            session()->flash('success', 'El profesor fue eliminado correctamente.');
        }
        return redirect()->back(); 
    }

    private function valid_data($request) {
        $group = Group::find($request->group_id);
        $subject = Subject::find($request->subject_id);
        $period = Period::find($request->period_id);

        if(isset($group) && isset($subject) && isset($period)) {
            return true;
        }

        return false;
    }

    private function saveResource(Request $request, $resource = null) 
    {   
        $values = ['subject_id' => $request->subject_id, 
                   'group_id' => $request->group_id, 
                   'period_id' => $request->period_id];

        if(isset($resource)) {
            $resource->update($values);
            $resource->generatePK();
            return $resource->update($values);
        } else {
            $resource = new Course($values);
            $resource->generatePK();
            $resource->clinic_id = clinic()->clinic_id;
            return $resource->save();
        }
    }
}
