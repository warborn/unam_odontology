<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Period;
class PeriodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:periods');
        $this->middleware('privileges.catalogs:periods', ['only' => 'index']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = Period::orderBy('period_start_date', 'DESC')->get();
        return $periods->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = ['period_id' => 'required|unique:periods|max:7'];
        return $this->makeValidation($request, $validations);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Period $period)
    {
        return response()->json($period);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Period $period)
    {
        $validations = ['period_id' => "required|unique:periods,period_id,{$period->period_id},period_id|max:7"];
        return $this->makeValidation($request, $validations, $period);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        $period->delete();
        return response()->json($period);
    }

    private function makeValidation(Request $request, $validations = [], $resource = null) 
    {
        $validator = Validator::make($request->all(), array_merge($validations, [
            'period_start_date' => 'required|date',
            'period_end_date' => 'required|date|after:' . $request->period_start_date
        ]));

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $values = ['period_id' => $request->period_id,
                   'period_start_date' => $request->period_start_date,
                   'period_end_date' => $request->period_end_date];

        if(isset($resource)) {
            $resource->update($values);
        } else {
            $resource = Period::create($values);
        }

        return response()->json($resource, 200);
    }
}
