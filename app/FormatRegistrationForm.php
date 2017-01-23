<?php

namespace App;
use Validator;

class FormatRegistrationForm
{
	private $rules = [
      'medical_history_number' => ['required', 'max:8', 'regex:/^(0[1-9]|1[0-2])[0-9][0-9][0-9][0-9][0-9][0-9]$/'],
      'has_disease' => 'required|boolean',
      'medical_treatment' => 'required|boolean',
      'referred_by' => 'max:50',
      'consultation_reason' => 'max:70',
      'observations' => 'max:250',
      'dental_disease' => 'required',
      // user data
      'name' => 'required|max:30',
      'last_name' => 'required|max:20',
      'mother_last_name' => 'required|max:20',
      'phone' => 'alpha_num',
      'street' => 'string|max:100',
      // patient data
      'age' => 'required|max:2',
      'ocupation' => 'required|max:25',
      'school_grade' => 'required|max:20',
      'civil_status' => 'required|max:25',
      'phone' => 'required|max:16',
      'has_medical_service' => 'required|boolean',
  ];

  private $request;
  private $validation;

  public function __construct($request)
  {
  	$this->request = $request;
  }

  public function isInvalid()
  {
  	return !$this->isValid();
  }

  public function isValid()
  {
  	// dd($this->request);
  	// dd($this->request->has_medical_service);
  	$other_disease_validation = ($this->request->has_disease && !isset($this->request->general_disease) ? 'required|' : '');
    $other_medical_service_validation = ($this->request->has_medical_service && !isset($this->request->medical_service) ? 'required|' : '');
    $therapeutic_used_validation = ($this->request->medical_treatment ? 'required|' : '');

    // dynamic validations
    $dynamic_validations = ['therapeutic_used' => $therapeutic_used_validation . 'max:100',
    'other_medical_service' => $other_medical_service_validation . 'max:25',
    'other_disease' => $other_disease_validation . 'max:30'];

  	$this->validation = Validator::make($this->request->all(), array_merge($this->rules, $dynamic_validations));
  	return $this->validation->passes();
  }

  public function getValidation()
  {
  	return $this->validation;
  }
}