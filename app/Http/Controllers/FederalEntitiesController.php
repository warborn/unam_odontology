<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\FederalEntity;
use App\Movement;

class FederalEntitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:federal-entities');
        $this->middleware('privileges.catalogs:federal-entities', ['only' => 'index']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entities = FederalEntity::orderBy('federal_entity_name')->get();
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
        $validations = ['federal_entity_name' => 'required|unique:federal_entities|max:35'];
        return $this->makeValidation($request, $validations);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FederalEntity $federal_entity)
    {

        return response()->json($federal_entity);
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
        $validations = ['federal_entity_name' => "required|unique:federal_entities,federal_entity_name,{$federal_entity->federal_entity_id},federal_entity_id|max:35"];
        return $this->makeValidation($request, $validations, $federal_entity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FederalEntity $federal_entity)
    {
        $federal_entity->delete();
        Movement::register(account(), null, 'federal-entities.destroy'); 
        return response()->json($federal_entity);
    }

    private function makeValidation(Request $request, $validations = [], $resource = null) 
    {
        $validator = Validator::make($request->all(), $validations);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $values = ['federal_entity_name' => $request->federal_entity_name];

        if(isset($resource)) {
            $resource->federal_entity_name = $request->federal_entity_name;
            $resource->generatePK();
            $resource->save();
            Movement::register(account(), null, 'federal-entities.update'); 
        } else {
            $resource = new FederalEntity($values);
            $resource->generatePK();
            $resource->save();
            Movement::register(account(), null, 'federal-entities.store'); 
        }

        return response()->json($resource, 200);
    }
}
