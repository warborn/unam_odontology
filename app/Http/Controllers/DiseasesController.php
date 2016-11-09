<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Disease;
class DiseasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diseases = Disease::all();
        return $diseases->toJson();
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
        $disease = new Disease([
            'disease_id' => $request->disease_id,
            'disease_name' => $request->disease_name,
            'type_of_disease' => $request->type_of_disease
            ]);
        if($disease->save()){
            return response()->json($disease, 201);
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
    public function update(Request $request, Disease $disease)
    {
        return $this->makeValidation($request, $disease);
        if($disease->update([
            'disease_id' => $request->disease_id,
            'disease_name' => $request->disease_name,
            'type_of_disease' => $request->type_of_disease
            ])){
            return response()->json($disease, 201);
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
    public function destroy(Disease $disease)
    {
        if($disease->delete()) {
            return response()->json($disease);
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
            'disease_id' => 'required|unique:groups|max:20',
            'disease_name' => 'required|max:150',
            'type_of_disease' => 'required|max:20'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if(isset($resource)) {
            $resource->update([
                'disease_id' => $request->disease_id,
                'disease_name' => $request->disease_name,
                'type_of_disease' => $request->type_of_disease
                ]);
        } else {
            $resource = Disease::create([
                'disease_id' => $request->disease_id,
                'disease_name' => $request->disease_name,
                'type_of_disease' => $request->type_of_disease
                ]);
        }

        return response()->json($resource, 200);
    }
}
