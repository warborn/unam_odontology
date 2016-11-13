<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FederalEntity $federal_entity)
    {
        return $this->makeValidation($request, $federal_entity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FederalEntity $federal_entity)
    {
        if($federal_entity->delete()) {
            return response()->json($federal_entity);
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
            'federal_entity_id' => 'required|unique:federalEntities|max:35'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $values=['federal_entity_id' => $request->federal_entity_id];
        if(isset($resource)) {
            $resource->update($values);
        } else {
            $resource = FederalEntity::create($values);
        }

        return response()->json($resource, 200);
    }
}
