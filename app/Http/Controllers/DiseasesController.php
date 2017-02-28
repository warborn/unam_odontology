<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Disease;
use App\Movement;
class DiseasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:diseases');
        $this->middleware('privileges.catalogs:diseases', ['only' => 'index']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diseases = Disease::orderBy('type_of_disease')->orderBy('disease_id')->get();
        return $diseases->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = ['disease_id' => 'required|unique:diseases|max:20'];
        return $this->makeValidation($request, $validations);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Disease $disease)
    {
        return response()->json($disease);
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
        $validations = ["disease_id' => 'required|unique:diseases,disease_id,{$disease->disease_id},disease_id|max:20"];

        return $this->makeValidation($request, $validations, $disease);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disease $disease)
    {
        $disease->delete();
        Movement::register(account(), null, 'diseases.destroy'); 
        return response()->json($disease);
    }
 
    private function makeValidation(Request $request, $validations = [], $resource = null) 
    {
        $validations = array_merge($validations, [
            'disease_name' => 'required|max:150',
            'type_of_disease' => 'required|max:20'
        ]);

        $validator = Validator::make($request->all(), $validations);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $values = ['disease_id' => $request->disease_id, 'disease_name' => $request->disease_name,
                   'type_of_disease' => $request->type_of_disease];

        if(isset($resource)) {
            $resource->update($values);
            Movement::register(account(), null, 'diseases.update'); 
        } else {
            $resource = new Disease($values);
            $resource->disease_id = $request->disease_id;
            $resource->save();
            Movement::register(account(), null, 'diseases.store'); 
        }

        return response()->json($resource, 200);
    }
}
