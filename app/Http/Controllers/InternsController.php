<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Intern;
use Validator;

class InternsController extends Controller
{
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Intern $intern)
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required|max:10',
            'service_start_date' => 'required|date',
            'service_end_date' => 'required|date|after:' . $request->service_start_date
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $values = [
            'account_number' => $request->account_number,
            'service_start_date' => $request->service_start_date,
            'service_end_date' => $request->service_end_date
        ];

        $intern->update($values);
        session()->flash('success', 'Se ha actualizado la información exitosamente.');
        return redirect()->back();
    }
}
