<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Privilege;
use App\Movement;
class PrivilegesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:privileges');
        $this->middleware('privileges.catalogs:privileges', ['only' => 'index']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $privileges = Privilege::orderBy('privilege_name')->get();
        return $privileges->toJson();        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = ['privilege_name' => 'required|max:100'];
        return $this->makeValidation($request, $validations);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Privilege $privilege)
    {
        return response()->json($privilege);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Privilege $privilege)
    {
        $validations = ['privilege_name' => "required|unique:privileges,privilege_name,{$privilege->privilege_id},privilege_id|max:100"];
        return $this->makeValidation($request, $validations, $privilege);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Privilege $privilege)
    {
        $privilege->delete();
        Movement::register(account(), null, 'privileges.destroy'); 
        return response()->json($privilege);
        
    }

    private function makeValidation(Request $request, $validations = [], $resource = null) 
    {
        $validator = Validator::make($request->all(), $validations);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $values = ['privilege_name' => $request->privilege_name];

        if(isset($resource)) {
            // Make use of update cascade and updates role_id
            // $resource->privilege_name = $request->privilege_name;
            // $resource->generatePK();
            // $resource->save();
            $resource->update($values);
            Movement::register(account(), null, 'privileges.update'); 
        } else {
            $resource = new Privilege($values);
            $resource->generatePK();
            $resource->save();
            Movement::register(account(), null, 'privileges.store'); 
        }

        return response()->json($resource, 200);
    }
}
