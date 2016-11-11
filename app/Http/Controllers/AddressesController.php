<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Address;
class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::all();
        return $addresses->toJson();
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
    public function update(Request $request,Address $address)
    {
        return $this->makeValidation($request, $address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if($address->delete()) {
            return response()->json($address);
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
            'address_id' => 'required|unique:groups|max:200',
            'postal_code' => 'required|max:6',
            'settlement' => 'required|max:70',
            'municipality' => 'required|max:35',
            'federal_entity_id' => 'required|max:35'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $datos=[
            'address_id' => $request->address_id,
            'postal_code' => $request->postal_code,
            'settlement' => $request->settlement,
            'municipality' => $request->municipality,
            'federal_entity_id' => $request->federal_entity_id
        ];
        if(isset($resource)) {
            $resource->update($datos);
        } else {
            $resource = Address::create($datos);
        }

        return response()->json($resource, 200);
    }
}
