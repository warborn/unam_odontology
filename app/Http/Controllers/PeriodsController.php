<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Period;
class PeriodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = Period::all();
        return $periods->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->makeValidation($request);
        $period = new Period([
            'period_id' => $request->period_id,
            'period_start_date' => $request->period_start_date,
            'period_end_date' => $request->period_end_date
            ]);
        if($period->save()){
            return response()->json($period, 201);
        }else{
            return response()->json([
                'error' =>true,
                'message' => 'error al guardar'
                ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        return $this->makeValidation($request, $period);
        if($period->update([
            'period_id' => $request->period_id,
            'period_start_date' => $request->period_start_date,
            'period_end_date' => $request->period_end_date
            ])){
            return response()->json($period, 201);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Error al modificar'
                ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        if($period->delete()) {
            return response()->json($period);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Error al eliminar'
            ], 400);
        }
    }

    private function makeValidation(Request $request, $resource = null) 
    {
        $validator = Validator::make($request->all(), [
            'period_id' => 'required|unique:periods|max:7',
            'period_start_date' => 'required',
            'period_end_date' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if(isset($resource)) {
            $resource->update([
                'period_id' => $request->period_id,
                'period_start_date' => $request->period_start_date,
                'period_end_date' => $request->period_end_date
                ]);
        } else {
            $resource = Period::create([
                'period_id' => $request->period_id,
                'period_start_date' => $request->period_start_date,
                'period_end_date' => $request->period_end_date
                ]);
        }

        return response()->json($resource, 200);
    }
}
