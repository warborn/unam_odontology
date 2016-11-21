<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
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

    public function index_privileges(Role $role)
    {
        $privileges = $role->privileges;
        return View('roles.index_privileges')->with('role' => $role)->with('privileges' => $privileges);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = ['role_name' => 'required|max:25'];
        return $this->makeValidation($request, $validations);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json($role);
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
        $validations = ['role_name' => "required|unique:roles,role_name,{$role->role_id},role_id|max:25"];
        return $this->makeValidation($request, $validations, $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json($role);
    }

    private function makeValidation(Request $request, $validations = [], $resource = null) 
    {
        $validations = array_merge($validations, ['role_description' => 'required']);
        $validator = Validator::make($request->all(), $validations);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $values = ['role_name' => $request->role_name,
                   'role_description' =>$request->role_description];

        if(isset($resource)) {
            $resource->update($values);
        } else {
            $resource = new Role($values);
            $resource->generatePK();
            $resource->save();
        }

        return response()->json($resource, 200);
    }
}
