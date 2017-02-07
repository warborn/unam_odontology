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
		return view('catalogs.index');
    }

    public function display($view) 
    {
    	return view('catalogs._' . $view . '_modal');
    }

    public function address_js() {
        $contents = view('shared._address_script');
        $response = response($contents, 200);
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }
}
