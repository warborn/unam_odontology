<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Clinic;
class ClinicsController extends Controller
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
        $clinics = Clinic::with('address')->get();
        return $clinics->toJson();
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Clinic $clinic)
    {
        return response()->json($clinic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Clinic $clinic)
    {
        return $this->makeValidation($request, $clinic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clinic $clinic)
    {
        if($clinic->delete()) {
            return response()->json($clinic);
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
            'clinic_id' => 'required|unique:clinics|max:25',
        	'address_id' => 'required|max:200',
        	'clinic_email' => 'required|max:25',
        	'clinic_phone' =>'required|max:16',
        	'street' => 'required|max:100'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $values=[
        	'clinic_id' => $request->clinic_id,
        	'address_id' => $request->address_id,
        	'clinic_email' => $request->clinic_email,
        	'clinic_phone' =>$request->clinic_phone,
        	'street' => $request->street
        ];
        if(isset($resource)) {
            $resource->update($values);
        } else {
            $resource = Clinic::create($values);
        }

        return response()->json($resource, 200);
    }
}
