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

class FormatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formats = Format::paginate(15);
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
        $medical = Disease::where('type_of_disease', 'general');
        $dental = Disease::where('type_of_disease', 'odontologica');
        $student = Student::all();
        $patient = Patient::find($patient->user_id);
        $subject = Subject::all();
        return View('formats.create')->with('patient', $patient)->with('federal', $federal)->with('address', $address)->with('medical', $medical)->with('dental', $dental)->with('student', $student)->with('subject', $subject);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Patient $patient)
    {
        try{
            $this->makeValidation($request);

        } catch(\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'No se guardo el formato error:'.$e->getCode());
            return redirect('patients/'.$patient.'formats/create');
        }
        session()->flash('success', 'El formato se guardo correctamente.');
        return redirect('formats');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($format)
    {
        $format = Format::find($format);
        $patient = Patient::find($format->user_patient_id);
        $intern = Intern::find($format->user_intern_id);
        $federal = FederalEntity::all();
        $address = Address::all();
        $medical = Disease::where('type_of_disease', 'general');
        $dental = Disease::where('type_of_disease', 'odontologica');
        $student = Student::all();
        $subject = Subject::all();
        return View('formats.show')->with('format', $format)->with('patient', $patient)->with('federal', $federal)->with('address', $address)->with('medical', $medical)->with('dental', $dental)->with('student', $student)->with('subject', $subject)->with('intern', $intern);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($format)
    {
        $format = Format::find($format);
        $patient = Patient::find($format->user_patient_id);
        $intern = Intern::find($format->user_intern_id);
        $federal = FederalEntity::all();
        $address = Address::all();
        $medical = Disease::where('type_of_disease', 'general');
        $dental = Disease::where('type_of_disease', 'odontologica');
        $student = Student::all();
        $subject = Subject::all();
        return View('formats.edit')->with('format', $format)->with('patient', $patient)->with('federal', $federal)->with('address', $address)->with('medical', $medical)->with('dental', $dental)->with('student', $student)->with('subject', $subject)->with('intern', $intern);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $format)
    {
        try{
            $this->makeValidation($request, $format);
        } catch(\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'El formato no se pudo modificar');
            return redirect('formats');
        }
        session()->flash('info', 'Se modifico el formato: '.$format->format_id);
        return redirect('formats');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($format)
    {
        try {
            $format->delete();
        } catch (\Illuminate\Database\QueryException $e){
            session()->flash('warning', 'El formato no se puede eliminar');
            return redirect('formats');
        }
        session()->flash('danger', 'El formato fue eliminado correctamente.');
        return redirect('formats'); 
    }

    private function makeValidation(Request $request, $resource = null) 
    {   
        

        $values = [
                    'format_id' => $request->format_id,
                    'user_intern_id' => $request->user_intern_id,  
                    'clinic_id' => $request->clinic_id, 
                    'user_patient_id' => $request->user_patient_id, 
                    'medical_history_number' => $request->medical_history_number, 
                    'hour_data_fill' => $request->hour_data_fill, 
                    'reason_consultation' => $request->reason_consultation, 
                    'disease' => $request->disease, 
                    'general_disease' => $request->general_disease, 
                    'other_disease' => $request->other_disease, 
                    'medical_treatment' => $request->medical_treatment, 
                    'therapeutic_used' => $request->therapeutic_used, 
                    'observations' => $request->observations, 
                    'referred_by' => $request->referred_by, 
                    'dental_disease' => $request->dental_disease, 
                    'format_status' => $request->format_status
                    ];

        if(isset($resource)) {
            $resource->update($values);
            $resource->generatePk();
            return $resource->update($values);
        } else {
            $resource = new Format($values);
            $resource->generatePK();
            return $resource->save();
        }
    }
}
