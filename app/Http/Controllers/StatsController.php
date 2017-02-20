<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Patient;
use App\Format;

class StatsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('privileges:stats');
    }

    public function index()
    {
    	$age_results = Patient::selectRaw("COUNT(*) as total, CASE WHEN age > 0  AND age <=  10 THEN '1-10' WHEN age > 10 AND age <=  20 THEN '11-20' WHEN age > 20 AND age <=  30 THEN '21-30' WHEN age > 30 AND age <=  40 THEN '31-40' WHEN age > 40 AND age <=  50 THEN '41-50' WHEN age > 50 AND age <=  60 THEN '51-60' WHEN age > 60 AND age <=  70 THEN '61-70' WHEN age > 70 AND age <= 80 THEN '71-80' WHEN age > 80 THEN '81+' END AS agegroup")->groupBy('agegroup')->get()->pluck('total', 'agegroup');

        $gender_results = Patient::join('personal_informations', 'personal_informations.user_id', '=', 'patients.user_id')->selectRaw("CASE WHEN gender = 'H' THEN 'Hombre' WHEN gender = 'M' THEN 'Mujer' END AS gender, COUNT(gender) AS total")->groupBy('gender')->get()->pluck('total', 'gender');

        $municipality_results = Patient::join('personal_informations', 'personal_informations.user_id', '=', 'patients.user_id')->join('addresses', 'personal_informations.address_id', '=', 'addresses.address_id')->selectRaw('municipality, COUNT(municipality) AS total')->groupBy('municipality')->orderBy('total', 'DESC')->limit(10)->get()->pluck('total', 'municipality');

        $dental_disease_results = Format::join('diseases', 'diseases.disease_id', '=', 'formats.dental_disease')->selectRaw('disease_name, COUNT(disease_id) AS total')->groupBy('disease_name')->orderBy('total', 'DESC')->limit(10)->get()->pluck('total', 'disease_name');

        $general_disease_results = Format::join('diseases', 'diseases.disease_id', '=', 'formats.general_disease')->selectRaw('disease_name, COUNT(disease_id) AS total')->groupBy('disease_name')->orderBy('total', 'DESC')->limit(10)->get()->pluck('total', 'disease_name');

    	$stats = [
    		'keys' => [
    			'age' => $age_results->keys(),
                'gender' => $gender_results->keys(),
                'municipality' => $municipality_results->keys(),
                'dental_disease' => $dental_disease_results->keys(),
                'general_disease' => $general_disease_results->keys(),
    		],
    		'values' => [
    			'age' => $age_results->values(),
                'gender' => $gender_results->values(),
                'municipality' => $municipality_results->values(),
                'dental_disease' => $dental_disease_results->values(),
                'general_disease' => $general_disease_results->values(),
    		]
    	];
    	return view('stats.index')->with('stats', $stats);
    }
}
