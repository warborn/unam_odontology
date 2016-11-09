<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return $roles->toJson();
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
        $role = new Role([
            'role_id' => $request->role_id,
            'role_name' => $request->role_name,
            'role_description' =>$request->role_description
            ]);
        if($role->save()){
            return response()->json($role, 201);
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
    public function update(Request $request, Role $role)
    {
        return $this->makeValidation($request, $role);
        if($role->update([
            'role_id' => $request->role_id,
            'role_name' => $request->role_name,
            'role_description' =>$request->role_description
            ])){
            return response()->json($role, 201);
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
    public function destroy(Role $role)
    {
        if($role->delete()) {
            return response()->json($role);
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
            'role_id' => 'required|unique:groups|max:10',
            'role_name' => 'required|max:25',
            'role_description' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if(isset($resource)) {
            $resource->update([
                'role_id' => $request->role_id,
                'role_name' => $request->role_name,
                'role_description' =>$request->role_description
                ]);
        } else {
            $resource = Role::create([
                'role_id' => $request->role_id,
                'role_name' => $request->role_name,
                'role_description' =>$request->role_description
                ]);
        }

        return response()->json($resource, 200);
    }
}
