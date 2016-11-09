<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Privilege;
class PrivilegesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $privileges = Privilege::all();
        return $privileges->toJson();        
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
        $privilege = new Privilege([
            'privilege_id' => $request->privilege_id,
            'privilege_name' =>$request->privilege_name
            ]);
        if($privilege->save()){
            return response()->json($privilege, 201);
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
    public function update(Request $request, Privilege $privilege)
    {
        return $this->makeValidation($request, $privilege);
        if($privilege->update([
            'privilege_id' => $request->privilege_id,
            'privilege_name' =>$request->privilege_name
            ])){
            return response()->json($privilege, 201);
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
    public function destroy(Privilege $privilege)
    {
         if($privilege->delete()) {
            return response()->json($privilege);
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
            'privilege_id' => 'required|unique:groups|max:10',
            'privilege_name' => 'required|max:100'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if(isset($resource)) {
            $resource->update([
                'privilege_id' => $request->privilege_id,
                'privilege_name' =>$request->privilege_name
                ]);
        } else {
            $resource = Privilege::create([
                'privilege_id' => $request->privilege_id,
                'privilege_name' =>$request->privilege_name
                ]);
        }

        return response()->json($resource, 200);
    }
}
