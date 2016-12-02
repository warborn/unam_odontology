<?php

namespace App\Http\Controllers;

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
use App\Intern;
use App\Course;
use App\Clinic;
use Carbon\Carbon;

class FormatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formats = Format::with('dentalDisease')->with('intern')->with('patient')->orderBy('created_at', 'DESC')->paginate(15);
        return View('formats.index')->with('formats', $formats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Patient $patient)
    {
        $federal = FederalEntity::all();
        $address = Address::all();
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        $patient = Patient::find($patient->user_id)->first();
        $courses = Course::all();
        return View('formats.create')->with('patient', $patient)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental)->with('courses', $courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Patient $patient)
    {
        $other_disease_validation = ($request->has_disease && !isset($request->general_disease) ? 'required|' : '');
        $therapeutic_used_validation = (($request->medical_treatment) ? 'required|' : '');
        $validator = Validator::make($request->all(), [
            'medical_history_number' => ['required', 'max:8', 'regex:/^(0[1-9]|1[0-2])[0-9][0-9][0-9][0-9][0-9][0-9]$/'],
            'has_disease' => 'required|boolean',
            'medical_treatment' => 'required|boolean',
            'referred_by' => 'max:50',
            'consultation_reason' => 'max:70',
            'therapeutic_used' => $therapeutic_used_validation . 'max:100',
            'observations' => 'max:250',
            'dental_disease' => 'required',
            'other_disease' => $other_disease_validation . 'max:30'
        ]);

        if($validator->fails()) {
            $federal = FederalEntity::all();
            $address = Address::all();
            $general = Disease::where('type_of_disease', 'general')->get();
            $dental = Disease::where('type_of_disease', 'odontologica')->get();
            return redirect()->back()->with('patient', $patient)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental)->withErrors($validator)->withInput($request->all());
        }

        $clinic = Clinic::first(); // replace with logged in clinic
        $intern = Intern::first(); // replace with logged in user
        $dental_disease = Disease::find($request->dental_disease);
        $general_disease = null;
        if($request->has_disease && isset($request->general_disease)) {
            $general_disease = Disease::find($request->general_disease);
        }

        if($patient && $dental_disease && (!$request->has_disease || $general_disease || $request->other_disease)) {
            $values = [
                    'medical_history_number' => $request->medical_history_number, 
                    'has_disease' => $request->has_disease, 
                    'medical_treatment' => $request->medical_treatment,
                    'referred_by' => $request->referred_by,
                    'consultation_reason' => $request->consultation_reason,
                    'observations' => $request->observations];

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
        $address = Address::all();
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        $students = Student::whereNotIn('user_id', $assigned_students->map(function($student) { return $student->user_id; }))->get();
        $students = $students->filter(function($student) { return $student->courses()->where('status', 'accepted')->count() > 0; });
        $courses = Course::all();
        return View('formats.show')->with('format', $format)->with('patient', $patient)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental)->with('students', $students)->with('assigned_students', $assigned_students);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Format $format)
    {
        $federal = FederalEntity::all();
        $address = Address::all();
        $general = Disease::where('type_of_disease', 'general')->get();
        $dental = Disease::where('type_of_disease', 'odontologica')->get();
        return View('formats.edit')->with('format', $format)->with('patient', $format->patient)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental);
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
        $other_disease_validation = ($request->has_disease && !isset($request->general_disease) ? 'required|' : '');
        $therapeutic_used_validation = (($request->medical_treatment) ? 'required|' : '');
        $validator = Validator::make($request->all(), [
            'medical_history_number' => ['required', 'max:8', 'regex:/^(0[1-9]|1[0-2])[0-9][0-9][0-9][0-9][0-9][0-9]$/'],
            'has_disease' => 'required|boolean',
            'medical_treatment' => 'required|boolean',
            'referred_by' => 'max:50',
            'consultation_reason' => 'max:70',
            'therapeutic_used' => $therapeutic_used_validation . 'max:100',
            'observations' => 'max:250',
            'dental_disease' => 'required',
            'other_disease' => $other_disease_validation . 'max:30'
        ]);

        if($validator->fails()) {
            $federal = FederalEntity::all();
            $address = Address::all();
            $general = Disease::where('type_of_disease', 'general')->get();
            $dental = Disease::where('type_of_disease', 'odontologica')->get();
            return redirect()->back()->with('format', $format)->with('patient', $format->patient)->with('federal', $federal)->with('address', $address)->with('general', $general)->with('dental', $dental)->withErrors($validator);
        }

        $clinic = Clinic::first(); // replace with logged in clinic
        $intern = Intern::first(); // replace with logged in user
        $dental_disease = Disease::find($request->dental_disease);
        $general_disease = null;
        if($request->has_disease && isset($request->general_disease)) {
            $general_disease = Disease::find($request->general_disease);
        }

        if($format->patient && $dental_disease && (!$request->has_disease || $general_disease || $request->other_disease)) {
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
    public function destroy(Format $format)
    {
        try {
            $format->delete();
            session()->flash('success', 'El formato fue eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'El formato no se puede eliminar');
        }
        return redirect('formats'); 
    }

    public function destroy_student(Format $format, Student $student)
    {
        $format->students()->detach($student->user_id);
        session()->flash('success', 'El alumno fue eliminado correctamente.');
        return redirect()->back();
    }
}
