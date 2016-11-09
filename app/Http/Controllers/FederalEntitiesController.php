<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\FederalEntity;
class FederalEntitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = FederalEntity::all();
        return $entities->toJson();
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
        $federal = new FederalEntity([
            'federal_entity_id' => $request->federal_entity_id
            ]);
        if($federal->save()){
            return response()->json($federal, 201);
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
    public function update(Request $request, FederalEntity $federal)
    {
        return $this->makeValidation($request, $federal);
        if($federal->update([
            'federal_entity_id' => $request->federal_entity_id
            ])){
            return response()->json($federal, 201);
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
    public function destroy(FederalEntity $federal)
    {
        if($federal->delete()) {
            return response()->json($federal);
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
            'federal_entity_id' => 'required|unique:groups|max:35'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if(isset($resource)) {
            $resource->update(['federal_entity_id' => $request->federal_entity_id]);
        } else {
            $resource = FederalEntity::create(['federal_entity_id' => $request->federal_entity_id]);
        }

        return response()->json($resource, 200);
    }
}
