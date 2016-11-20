<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Subject;
class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        return $subjects->toJson();
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        return response()->json($subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        return $this->makeValidation($request, $subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json($federal_entity);
    }

    private function makeValidation(Request $request, $resource = null) 
    {
        $validator = Validator::make($request->all(), [
            'subject_name' => 'required',
            'semester' => 'required|max:3' 
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        
        $values = ['subject_name' => $request->subject_name,
                   'semester' => $request->semester];

        if(isset($resource)) {
            $resource->update($values);
        } else {
            $resource = new Subject($values);
            $resource->generatePK();
            $resource->save();
        }

        return response()->json($resource, 200);
    }
}
