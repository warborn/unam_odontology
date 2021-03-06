<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Patient;
use App\FederalEntity;
use App\Student;
use App\Disease;
use App\Address;
use App\Subject;
use App\Format;
use App\User;
use App\PersonalInformation;
use App\Intern;
use App\Course;
use App\Clinic;
use App\Account;
use App\FormatRegistrationForm;
Use App\Movement;
use Carbon\Carbon;

class FormatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:formats');
        $this->middleware('check.clinic:format', ['except' => ['index', 'create', 'store']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $format_builder = Format::fromClinic(clinic())->select('formats.*');

        $filtering = false;

        if(!empty($request->search)) {
            $format_builder = $format_builder->search($request->search);
            $filtering = true;
        } 

        if(!empty($request->start_date) && !empty($request->end_date)) {
            $format_builder = $format_builder->between($request->start_date, $request->end_date);
            $filtering = true;
        }

        $search = $request->search;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $formats = $format_builder->orderBy('formats.fill_datetime', 'DESC')->customPaginate(5, $request, $filtering);
        
        return View('formats.index')->with('formats', $formats)->with('search', $search)
                                    ->with('start_date', $start_date)->with('end_date', $end_date);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // static data for patient information
        $school_grades = to_associative(['Kinder','Primaria', 'Secundaria', 'Preparatoria', 'Universidad', 'Maestria', 'Doctorado']);
        $ocupations = to_associative(['Empleado','Estudiante', 'Otro']);
        $civil_status = to_associative(['Solter@', 'Casad@', 'Divorciad@', 'Viud@']);
        $medical_services = to_associative(['IMSS', 'ISSSTE', 'POPULAR']);

        $federal = FederalEntity::all();
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        return View('formats.create')->with('ocupations', $ocupations)->with('school_grades', $school_grades)->with('civil_status', $civil_status)->with('medical_services', $medical_services)->with('federal', $federal)->with('general', $general)->with('dental', $dental);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = new FormatRegistrationForm($request);

        if($form->isInvalid()) {
            // static data for patient information
            $school_grades = to_associative(['Kinder','Primaria', 'Secundaria', 'Preparatoria', 'Universidad', 'Maestria', 'Doctorado']);
            $ocupations = to_associative(['Empleado','Estudiante', 'Otro']);
            $civil_status = to_associative(['Solter@', 'Casad@', 'Divorciad@', 'Viud@']);
            $medical_services = to_associative(['IMSS', 'ISSSTE', 'POPULAR']);

            $federal = FederalEntity::all();
            $general = Disease::where('type_of_disease', 'general')->get();
            $dental = Disease::where('type_of_disease', 'odontologica')->get();
            return redirect()->route('formats.create')->with('ocupations', $ocupations)->with('school_grades', $school_grades)->with('civil_status', $civil_status)->with('medical_services', $medical_services)->with('federal', $federal)->with('general', $general)->with('dental', $dental)->withErrors($form->getValidation())->withInput($request->all());
        }

        $clinic = clinic(); // use clinic registered in session
        $intern = intern(); // use user registered in session

        $dental_disease = Disease::find($request->dental_disease);
        $general_disease = null;
        if($request->has_disease && isset($request->general_disease)) {
            $general_disease = Disease::find($request->general_disease);
        }

        // get address_id based on state, municipality and settlement
        $address = Address::fromFields($request);

        if($address && $dental_disease && (!$request->has_disease || $general_disease || $request->other_disease)) {

            // create new user 
            $user = User::create(['user_id' => uniqid('_PAS_'), 'password' => bcrypt(md5(rand()))]);
            $personal_information = new PersonalInformation($request->all());
            $personal_information->address()->associate($address);
            $user->personal_information()->save($personal_information);

            //     // Set account to user
            $account = new Account(['user_id' => $user->user_id, 'clinic_id' => clinic()->clinic_id]);
            $account->generatePK();
            $user->accounts()->save($account);

            // create new patient
            $patient = new Patient($request->all());
            $patient->federal_entity_id = $request->federal_entity_id;
            $user->patient()->save($patient);

            $values = [
                    'medical_history_number' => $request->medical_history_number, 
                    'has_disease' => $request->has_disease, 
                    'medical_treatment' => $request->medical_treatment,
                    'referred_by' => $request->referred_by,
                    'consultation_reason' => $request->consultation_reason,
                    'observations' => $request->observations,
                    'has_medical_service' => $request->has_medical_service,
                    'medical_service' => $request->medical_service,
                    'other_medical_service' => $request->other_medical_service
                    ];

            $format = new Format($values);
            $format->generatePK();
            $format->clinic()->associate($clinic);
            $format->intern()->associate($intern);
            $format->patient()->associate($patient);
            $format->dentalDisease()->associate($dental_disease);
            $format->fill_datetime = new Carbon();
            if($request->has_disease) {
                if($general_disease) {
                    $format->generalDisease()->associate($general_disease);
                } else {
                    $format->other_disease = $request->other_disease;
                }
            }

            if($request->medical_treatment) {
                $format->therapeutic_used = $request->therapeutic_used;
            }

            $format->save();
            Movement::register(account(), $account, 'formats.store'); // store format
            
            session()->flash('success', 'El formato se creo correctamente.');
        } else {
            session()->flash('danger', 'Hubo un error al crear el formato.');
        }
        return redirect()->route('formats.index');
    }

    public function store_student(Request $request, Format $format)
    {
        $course = Course::fromClinic(clinic())->find($request->course_id);
        $student = Student::find($request->user_id);
        if(isset($course) && isset($student) && $course->has_student($student) && !$format->has_student($student)) {
            $format->students()->attach($student->user_id, ['course_id' => $course->course_id]);
            Movement::register(account(), $student->account(clinic()), 'formats.store_student'); // store format
            session()->flash('success', 'El estudiante fue asignado correctamente.');
        } else {
            session()->flash('danger', 'Hubo un problema al asignar al estudiante.');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Format $format)
    {
        $assigned_students = $format->students()->join('courses', 'format_student.course_id', '=', 'courses.course_id')->join('subjects', 'courses.subject_id', '=', 'subjects.subject_id')->select('students.*', 'subjects.subject_name', 'courses.*')->get();
        $patient = $format->patient;
        $intern = $format->intern;
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        $students = Student::activated()->fromClinic(clinic())->whereNotIn('students.user_id', $assigned_students->map(function($student) { return $student->user_id; }))->get();
        $students = $students->filter(function($student) { return $student->courses()->where('status', 'accepted')->count() > 0; });
        return View('formats.show')->with('format', $format)->with('patient', $format->patient)->with('general', $general)->with('dental', $dental)->with('students', $students)->with('assigned_students', $assigned_students);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Format $format)
    {
        if(!$format->filled_by(intern())) {
            return redirect()->route('formats.index');
        }
        // static data for patient information
        $school_grades = to_associative(['Kinder','Primaria', 'Secundaria', 'Preparatoria', 'Universidad', 'Maestria', 'Doctorado']);
        $ocupations = to_associative(['Empleado','Estudiante', 'Otro']);
        $civil_status = to_associative(['Solter@', 'Casad@', 'Divorciad@', 'Viud@']);
        $medical_services = to_associative(['IMSS', 'ISSSTE', 'POPULAR']);

        $federal = FederalEntity::find($format->patient->federalEntity->federal_entity_id);
        $municipality = to_associative([$format->patient->personal_information->address->municipality]);
        $settlements = Address::where('postal_code', $format->patient->personal_information->address->postal_code);
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        return View('formats.edit')->with('ocupations', $ocupations)->with('school_grades', $school_grades)->with('civil_status', $civil_status)->with('medical_services', $medical_services)->with('federal', $federal)->with('municipality', $municipality)->with('settlements', $settlements)->with('general', $general)->with('dental', $dental)->with('patient', $format->patient)->with('format', $format);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Format $format)
    {
        if(!$format->filled_by(intern())) {
            return redirect()->route('formats.index');
        }
        
        $form = new FormatRegistrationForm($request);

        if($form->isInvalid()) {
            // static data for patient information
            $school_grades = to_associative(['Kinder','Primaria', 'Secundaria', 'Preparatoria', 'Universidad', 'Maestria', 'Doctorado']);
            $ocupations = to_associative(['Empleado','Estudiante', 'Otro']);
            $civil_status = to_associative(['Solter@', 'Casad@', 'Divorciad@', 'Viud@']);
            $medical_services = to_associative(['IMSS', 'ISSSTE', 'POPULAR']);

            $federal = FederalEntity::all();
            $general = Disease::where('type_of_disease', 'general')->get();
            $dental = Disease::where('type_of_disease', 'odontologica')->get();
            return redirect()->route('formats.edit', $format)->with('ocupations', $ocupations)->with('school_grades', $school_grades)->with('civil_status', $civil_status)->with('medical_services', $medical_services)->with('federal', $federal)->with('general', $general)->with('dental', $dental)->with('format', $format)->with('patient', $format->patient)->withErrors($form->getValidation())->withInput($request->all());
        }

        $dental_disease = Disease::find($request->dental_disease);
        $general_disease = null;
        if($request->has_disease && isset($request->general_disease)) {
            $general_disease = Disease::find($request->general_disease);
        }
        
        $address = Address::fromFields($request);

        if($address && $dental_disease && (!$request->has_disease || $general_disease || $request->other_disease)) {
            // dd($address);
            // update user personal information 
            $patient = $format->patient;
            $patient->user->personal_information->update(array_merge(['address_id' => $address->address_id], $request->all()));

            // update patient information
            $patient->federal_entity_id = $request->federal_entity_id;
            $patient->update(['age' => $request->age, 'ocupation' => $request->ocupation, 'school_grade' => $request->school_grade, 'civil_status' => $request->civil_status, 'phone' => $request->phone, 'has_medical_service' => $request->has_medical_service, 'medical_service' => $request->medical_service, 'other_medical_service' => $request->other_medical_service]);

            $values = [
                    'medical_history_number' => $request->medical_history_number, 
                    'has_disease' => $request->has_disease, 
                    'medical_treatment' => $request->medical_treatment,
                    'referred_by' => $request->referred_by,
                    'consultation_reason' => $request->consultation_reason,
                    'observations' => $request->observations];

            $format->dentalDisease()->associate($dental_disease);
            
            if($request->has_disease) {
                if($general_disease) {
                    $format->generalDisease()->associate($general_disease);
                    $format->other_disease = null;
                } else {
                    $format->general_disease = null;
                    $format->other_disease = $request->other_disease;
                }
            } else {
                $format->general_disease = null;
                $format->other_disease = null;
            }

            if($request->medical_treatment) {
                $format->therapeutic_used = $request->therapeutic_used;
            } else {
                $format->therapeutic_used = null;
            }

            $format->update($values);
            Movement::register(account(), $patient->account(clinic()), 'formats.update'); // update format
            
            session()->flash('success', 'El formato se modifico correctamente.');
        } else {
            session()->flash('danger', 'Hubo un error al modificar el formato.');
        }
        // return redirect('formats');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Format $format)
    // {
    //     try {
    //         $format->delete();
    //         session()->flash('success', 'El formato fue eliminado correctamente.');
    //     } catch (\Illuminate\Database\QueryException $e){
    //         session()->flash('warning', 'El formato no se puede eliminar');
    //     }
    //     return redirect('formats'); 
    // }

    public function destroy_student(Format $format, Student $student)
    {
        if($format->has_student($student)) {
            $format->students()->detach($student->user_id);
            Movement::register(account(), $student->account(clinic()), 'formats.destroy_student'); // store format
            session()->flash('success', 'El estudiante fue eliminado correctamente.');
        }
        return redirect()->back();
    }
}
