<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Account;
use App\Role;
use App\Privilege;
use App\InactiveAccount;


class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::with('user.personal_information')->get();
        return View('accounts.index')->with('accounts', $accounts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        $roles = Role::pluck('role_name','role_id');
        $roles = $roles->diffKeys($account->roles->pluck('role_name','role_id'));
        $deactivation = ['disabled' => 'deshabilitar', 'deleted' => 'eliminar'];

        $account->load('user.personal_information')->load('roles');
        return View('accounts.show')->with('account', $account)->with('roles', $roles)->with('deactivation', $deactivation);
    }

    public function store_role(Request $request, Account $account)
    {
        $role = Role::findOrFail($request->role_id);
        $account->roles()->attach($role->role_id);
        session()->flash('success', 'El rol fue asignado correctamente.');
        return redirect()->back();
    }

    public function destroy_role(Account $account, Role $role)
    {
        $account->roles()->detach($role->role_id);
        session()->flash('success', 'El rol fue eliminado correctamente.');
        return redirect()->back();
    }

    public function store_disabled_privilege(Account $account, Privilege $privilege) {
        $account->disabledPrivileges()->attach($privilege->privilege_id);
        return redirect()->back();
    }

    public function destroy_disabled_privilege(Account $account, Privilege $privilege) {
        $account->disabledPrivileges()->detach($privilege->privilege_id);
        return redirect()->back();
    }

    public function deactivate(Request $request, Account $account) {
        $account->inactiveAccount()->save(new InactiveAccount($request->all()));
        session()->flash('success', 'Se ha desactivado esta cuenta correctamente.');
        return redirect()->back();
    }

    public function activate(Account $account) {
        $account->inactiveAccount()->delete();
        session()->flash('success', 'Se ha activado esta cuenta correctamente.');
        return redirect()->back();
    }
}
