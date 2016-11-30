<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
