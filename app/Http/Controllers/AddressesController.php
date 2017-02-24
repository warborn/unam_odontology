<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Address;
use App\FederalEntity;
class AddressesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:addresses', ['except' => 'index_by_postal_code']);
        $this->middleware('privileges.catalogs:addresses', ['only' => 'index']);
    }

    public function index_by_postal_code($code)
    {
        $addresses = Address::where('postal_code', $code)->get();
        $states = $state = $municipality = null;
        if(count($addresses) > 0) {
            $state = $addresses[0]->federal_entity_id;
            $municipality = $addresses[0]->municipality;
            $states = FederalEntity::where('federal_entity_id', $state)->get();
        }

        return response()->json([
            // 'states' => FederalEntity::all(),
            'states' => ($states !== null ? $states : FederalEntity::all()),
            'municipalities' => Address::select('municipality')->distinct()->where('federal_entity_id', $state)->where('postal_code', $code)->get(),
            'settlements' => $addresses,
            'state' => $state,
            'municipality' => $municipality
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::with('federalEntity')->limit(20)->orderBy('created_at', 'DESC')->get();
        return $addresses->toJson();
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
    public function show(Address $address)
    {
        return response()->json($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Address $address)
    {
        return $this->makeValidation($request, $address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if($address->delete()) {
            return response()->json($address);
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
            'postal_code' => 'required|max:6',
            'settlement' => 'required|max:70',
            'municipality' => 'required',
            'state' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $values=[
        'postal_code' => $request->postal_code,
        'settlement' => $request->settlement,
        'municipality' => $request->municipality,
        'federal_entity_id' => $request->state
        ];
        if(isset($resource)) {
            $resource->update($values);
        } else {
            $resource = new Address($values);
            $resource->generatePK();
            $resource->save();
        }

        return response()->json($resource, 200);
    }
}
