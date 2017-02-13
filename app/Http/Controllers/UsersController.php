<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'last_name' => 'required|max:20',
            'mother_last_name' => 'required|max:20',
            'phone' => 'alpha_num',
            'street' => 'string|max:100',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $values = [
            'name' => $request->name,
            'last_name' => $request->last_name,
            'mother_last_name' => $request->mother_last_name,
            'phone' => $request->phone,
            'street' => $request->street,
        ];

        $user->personal_information()->update($values);
        session()->flash('success', 'Se ha actualizado la información exitosamente.');
        return redirect()->back();
    }

    public function profile() 
    {
        $user = Auth::user()->load('personal_information');
        return View('users.profile')->with('user', $user);
    }

    public function update_password(Request $request) 
    {
        $user = Auth::user();

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        if(Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            session()->flash('success', 'Se ha cambiado la contraseña exitosamente.');
        } else {
            session()->flash('danger', 'La contraseña introducida no esta asociada a tu cuenta.');
        }
        return redirect()->back();
    }
}
