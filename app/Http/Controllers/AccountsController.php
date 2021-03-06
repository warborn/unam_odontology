<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Account;
use App\User;
use App\Role;
use App\Privilege;
use App\Movement;
use App\InactiveAccount;


class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:accounts');
        $this->middleware('account', ['except' => ['index']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::activated()->notPatient()->fromClinic(clinic())->with('user.personal_information')->get();
        return View('accounts.index')->with('accounts', $accounts);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $account = Account::from($user->user_id, clinic()->clinic_id);
        $roles = account()->enabled_role_privileges('role.store')->pluck('role_name','role_id');

        $roles = $roles->diffKeys($account->roles->pluck('role_name','role_id'));
        $deactivation = ['disabled' => 'deshabilitar', 'deleted' => 'eliminar'];

        $account->load('user.personal_information')->load('roles');
        return View('accounts.show')->with('account', $account)->with('roles', $roles)->with('deactivation', $deactivation);
    }

    public function store_role(Request $request, User $user)
    {
        // Get account based on selected user and logged in clinic
        $account = Account::from($user->user_id, clinic()->clinic_id);
        $role = Role::find($request->role_id);

        if(isset($role) && account()->allow_role_action('role.store', $role)) {
            if(!$account->has_role($role)) {
                $account->roles()->attach($role->role_id);
                Movement::register(account(), $account, $account->get_action_by_role('store', $role)); // assign role movement
            }
            if(!$account->has_profile($role)) {
                $account->assign_profile($role);
            }
            session()->flash('success', 'El rol fue asignado correctamente.');
        } else {
            session()->flash('danger', 'Hubo un problema al asignar el rol.');
        }
        return redirect()->back();
    }

    public function destroy_role(User $user, Role $role)
    {
        $account = Account::from($user->user_id, clinic()->clinic_id);
        if(isset($role) && account()->allow_role_action('role.destroy', $role)) {
            $account->roles()->detach($role->role_id);
            $account->destroy_disabled_privileges($role);
            Movement::register(account(), $account, $account->get_action_by_role('destroy', $role));  // remove role
            session()->flash('success', 'El rol fue eliminado correctamente.');
        } else {
            session()->flash('danger', 'Hubo un problema al eliminar el rol.');
        }
        return redirect()->back();
    }

    public function store_disabled_privilege(User $user, Privilege $privilege) {
        $account = Account::from($user->user_id, clinic()->clinic_id);
        $account->disabledPrivileges()->attach($privilege->privilege_id);
        Movement::register(account(), $account, 'accounts.store_disabled_privilege');  // disable privilege
        return redirect()->back();
    }

    public function destroy_disabled_privilege(User $user, Privilege $privilege) {
        $account = Account::from($user->user_id, clinic()->clinic_id);
        $account->disabledPrivileges()->detach($privilege->privilege_id);
        Movement::register(account(), $account, 'accounts.destroy_disabled_privilege');  // enable privilege
        return redirect()->back();
    }

    public function deactivate(Request $request, User $user) {
        $account = Account::from($user->user_id, clinic()->clinic_id);
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'reason' => 'max:150'
        ]);

        if($validator->fails()) {
            $roles = Role::pluck('role_name','role_id');
            $roles = $roles->diffKeys($account->roles->pluck('role_name','role_id'));
            $deactivation = ['disabled' => 'deshabilitar', 'deleted' => 'eliminar'];

            $account->load('user.personal_information')->load('roles');
            return redirect()->back()->with('account', $account)->with('roles', $roles)
                ->with('deactivation', $deactivation)->withErrors($validator)->withInput();
        }

        $account->inactiveAccount()->save(new InactiveAccount($request->all()));
        Movement::register(account(), $account, 'accounts.deactivate');  // inactivate account
        session()->flash('success', 'Se ha desactivado esta cuenta correctamente.');
        return redirect()->back();
    }

    public function activate(User $user) {
        $account = Account::from($user->user_id, clinic()->clinic_id);
        $account->inactiveAccount()->delete();
        Movement::register(account(), $account, 'accounts.activate');  // activate account
        session()->flash('success', 'Se ha activado esta cuenta correctamente.');
        return redirect()->back();
    }
}
