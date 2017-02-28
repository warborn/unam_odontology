<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Clinic;
use App\Address;
use App\Movement;
class ClinicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:clinics');
        $this->middleware('privileges.catalogs:clinics', ['only' => 'index']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinics = Clinic::with('address.federalEntity')->orderBy('clinic_id')->get();
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
        $validations = ['clinic_id' => 'required|unique:clinics|max:25'];
        return $this->makeValidation($request, $validations);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Clinic $clinic)
    {
        return response()->json($clinic->load('address'));
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
        $validations = ['clinic_id' => "required|unique:clinics,clinic_id,{$clinic->clinic_id},clinic_id|max:25"];
        return $this->makeValidation($request, $validations, $clinic);
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
            Movement::register(account(), null, 'clinics.destroy'); 
            return response()->json($clinic);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Error al eliminar'
            ], 400);
        }
    }

    private function makeValidation(Request $request, $validations, $resource = null) 
    {
        $validator = Validator::make($request->all(), array_merge($validations, [
            'state' => 'required',
            'municipality' => 'required',
            'settlement' => 'required',
            'postal_code' => 'required',
        	'clinic_email' => 'required|max:25',
        	'clinic_phone' =>'required|max:16',
        	'street' => 'required|max:100'
        ]));

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $address = Address::fromFields($request);
        if($address) {
            $values=[
            'clinic_id' => $request->clinic_id,
            'address_id' => $address->address_id,
            'clinic_email' => $request->clinic_email,
            'clinic_phone' =>$request->clinic_phone,
            'street' => $request->street
            ];
            if(isset($resource)) {
                $resource->update($values);
                Movement::register(account(), null, 'clinics.update'); 
            } else {
                $resource = Clinic::create($values);
                $resource->load('address');
                Movement::register(account(), null, 'clinics.store');     
            }
        }

        return response()->json($resource->load('address'), 200);
    }
}
