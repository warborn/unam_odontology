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
        if($subject->delete()) {
            return response()->json($subject);
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
            'subject_id' => 'required|unique:subjects|max:15',
            'subject_name' => 'required',
            'semester' => 'required|max:3' 
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $values=[
                'subject_id' => $request->subject_id,
                'subject_name' => $request->subject_name,
                'semester' => $request->semester
                ];
        if(isset($resource)) {
            $resource->update($values);
        } else {
            $resource = Subject::create($values);
        }

        return response()->json($resource, 200);
    }
}
