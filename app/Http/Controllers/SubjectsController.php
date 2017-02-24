<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Subject;
class SubjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:subjects');
        $this->middleware('privileges.catalogs:subjects', ['only' => 'index']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::orderBy('subject_id')->get();
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
        $validations = ['subject_id' => 'required|unique:subjects|max:15'];
        return $this->makeValidation($request, $validations);
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
        $validations = ['subject_id' => "required|unique:subjects,subject_id,{$subject->subject_id},subject_id|max:15"];
        return $this->makeValidation($request, $validations, $subject);
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
        return response()->json($subject);
    }

    private function makeValidation(Request $request, $validations = [], $resource = null) 
    {
        $validator = Validator::make($request->all(), array_merge($validations, [
            'subject_name' => 'required',
            'semester' => 'required|max:3' 
        ]));

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        
        $values = ['subject_id' => $request->subject_id,
                   'subject_name' => $request->subject_name,
                   'semester' => $request->semester];

        if(isset($resource)) {
            $resource->update($values);
        } else {
            $resource = new Subject($values);
            // $resource->generatePK();
            $resource->save();
        }

        return response()->json($resource, 200);
    }
}
