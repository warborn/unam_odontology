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
use Carbon\Carbon;

class FormatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intern = account()->user->intern;
        $formats = Format::orderBy('created_at', 'DESC')->paginate(15);
        return View('formats.index')->with('formats', $formats);
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
        $ocupations = to_associative(['Seleccione','Empleado','Estudiante', 'Otro']);
        $civil_status = to_associative(['Solter@', 'Casad@', 'Divorciad@', 'Viud@']);
        $medical_services = to_associative(['IMSS', 'ISSSTE', 'POPULAR']);

        $federal = FederalEntity::first();
        $address = $federal->addresses->first();
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        $courses = Course::all();
        return View('formats.create')->with('ocupations', $ocupations)->with('school_grades', $school_grades)->with('civil_status', $civil_status)->with('medical_services', $medical_services)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental);
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
            $ocupations = to_associative(['Seleccione','Empleado','Estudiante', 'Otro']);
            $civil_status = to_associative(['Solter@', 'Casad@', 'Divorciad@', 'Viud@']);
            $medical_services = to_associative(['IMSS', 'ISSSTE', 'POPULAR']);

            $federal = FederalEntity::first();
            $address = $federal->addresses->first();
            $general = Disease::where('type_of_disease', 'general')->get();
            $dental = Disease::where('type_of_disease', 'odontologica')->get();
            $courses = Course::all();
            return View('formats.create')->with('ocupations', $ocupations)->with('school_grades', $school_grades)->with('civil_status', $civil_status)->with('medical_services', $medical_services)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental)->withErrors($form->getValidation())->withInput($request->all());
        }

        $clinic = clinic(); // use clinic registered in session
        $intern = Intern::first(); // use user registered in session

        $dental_disease = Disease::find($request->dental_disease);
        $general_disease = null;
        if($request->has_disease && isset($request->general_disease)) {
            $general_disease = Disease::find($request->general_disease);
        }

        if($dental_disease && (!$request->has_disease || $general_disease || $request->other_disease)) {
            $address = Address::first();

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
            $format->hour_date_fill = new Carbon();
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
            
            session()->flash('success', 'El formato se creo correctamente.');
        } else {
            session()->flash('danger', 'Hubo un error al crear el formato.');
        }
        return redirect('formats');
    }

    public function store_student(Request $request, Format $format)
    {
        $course = Course::find($request->course_id);
        $student = Student::find($request->user_id);
        if(isset($course) && isset($student)) {
            $format->students()->attach($student->user_id, ['course_id' => $course->course_id]);
            session()->flash('success', 'El alumno fue asignado correctamente.');
        } else {
            session()->flash('danger', 'Hubo un problema al asignar al alumno.');
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
        $patient = Patient::find($format->user_patient_id)->first();
        $intern = Intern::find($format->user_intern_id)->first();
        $federal = FederalEntity::all();
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        $students = Student::activated()->fromClinic(clinic())->whereNotIn('user_id', $assigned_students->map(function($student) { return $student->user_id; }))->get();
        $students = $students->filter(function($student) { return $student->courses()->where('status', 'accepted')->count() > 0; });
        return View('formats.show')->with('format', $format)->with('patient', $format->patient)->with('federal', $federal)->with('general', $general)->with('dental', $dental)->with('students', $students)->with('assigned_students', $assigned_students);
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
        $ocupations = to_associative(['Seleccione','Empleado','Estudiante', 'Otro']);
        $civil_status = to_associative(['Solter@', 'Casad@', 'Divorciad@', 'Viud@']);
        $medical_services = to_associative(['IMSS', 'ISSSTE', 'POPULAR']);

        $federal = FederalEntity::first();
        $address = $federal->addresses->first();
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        $courses = Course::all();
        return View('formats.edit')->with('ocupations', $ocupations)->with('school_grades', $school_grades)->with('civil_status', $civil_status)->with('medical_services', $medical_services)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental)->with('patient', $format->patient)->with('format', $format);
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
            $ocupations = to_associative(['Seleccione','Empleado','Estudiante', 'Otro']);
            $civil_status = to_associative(['Solter@', 'Casad@', 'Divorciad@', 'Viud@']);
            $medical_services = to_associative(['IMSS', 'ISSSTE', 'POPULAR']);

            $federal = FederalEntity::first();
            $address = $federal->addresses->first();
            $general = Disease::where('type_of_disease', 'general')->get();
            $dental = Disease::where('type_of_disease', 'odontologica')->get();
            $courses = Course::all();
            return View('formats.edit')->with('ocupations', $ocupations)->with('school_grades', $school_grades)->with('civil_status', $civil_status)->with('medical_services', $medical_services)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental)->with('format', $format)->with('patient', $format->patient)->withErrors($form->getValidation())->withInput($request->all());
        }

        $dental_disease = Disease::find($request->dental_disease);
        $general_disease = null;
        if($request->has_disease && isset($request->general_disease)) {
            $general_disease = Disease::find($request->general_disease);
        }

        if($dental_disease && (!$request->has_disease || $general_disease || $request->other_disease)) {
            // update user personal information 
            $patient = $format->patient;
            $patient->user->personal_information->update($request->all());

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
            $format->hour_date_fill = new Carbon();
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
        $format->students()->detach($student->user_id);
        session()->flash('success', 'El alumno fue eliminado correctamente.');
        return redirect()->back();
    }
}
