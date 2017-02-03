<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Role;
use App\Privilege;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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
        $privileges = Privilege::orderBy('privilege_name')->pluck('privilege_name','privilege_id');
        $privileges = $privileges->diffKeys($role->privileges->pluck('privilege_name','privilege_id'));
        return View('roles.index_privileges')->with('role', $role)->with('privileges', $privileges);
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

    public function store_privilege(Request $request, Role $role)
    {
        $privilege = Privilege::find($request->privilege_id);
        if(isset($privilege)) {
            $role->privileges()->attach($privilege->privilege_id);
            session()->flash('success', 'El privilegio fue asignado correctamente.');
        } else {
            session()->flash('danger', 'Hubo un problema al asignar el privilegio.');
        }
        return redirect()->back();
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

    public function destroy_privilege(Role $role, Privilege $privilege)
    {
        $role->privileges()->detach($privilege->privilege_id);
        session()->flash('success', 'El privilegio fue eliminado correctamente.');
        return redirect()->back();
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
