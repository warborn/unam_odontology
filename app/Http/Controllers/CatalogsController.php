<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CatalogsController extends Controller
{
    public function __construct() 
    {
      $this->middleware('auth');
      $this->middleware('privileges:catalogs');
    }

    public function index() 
    {       
        $catalogs = ['groups' => ['body' => 'Grupos'], 
                     'periods' => ['body' => 'Periodos'], 
                     'subjects' => ['body' => 'Asignaturas'], 
                     'diseases' => ['body' => 'Enfermedades'], 
                     'clinics' => ['body' => 'Clinicas'], 
                     'addresses' => ['body' => 'Direcciones'], 
                     'federal-entities' => ['body' => 'Entidades Federativas'], 
                     'roles' => ['body' => 'Roles'],
                     'privileges' => ['body' => 'Privilegios']]; 

        $catalogs = collect($catalogs)->map(function($properties, $catalog_name) {
            return [$catalog_name => ['enabled' => isset(account()->get_catalog_privileges($catalog_name)['index']),
                                      'body' => $properties['body']]];
        })->flatten(1);

		return view('catalogs.index')->with('catalogs', $catalogs);
    }

    public function display($view) 
    {
        $singulars = ['groups' => 'group', 'periods' => 'period', 
                        'subjects' => 'subject', 'privileges' => 'privilege', 
                        'roles' => 'role', 'federal-entities' => 'federal-entity',
                        'diseases' => 'disease', 'addresses' => 'address', 
                        'clinics' => 'clinic'];
    	return view('catalogs._' . $singulars[$view] . '_modal');
    }

    public function address_js() {
        $contents = view('shared._address_js');
        $response = response($contents, 200);
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }

    public function datetimepicker_js() {
        $contents = view('shared._datetimepicker_js');
        $response = response($contents, 200);
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }
}
