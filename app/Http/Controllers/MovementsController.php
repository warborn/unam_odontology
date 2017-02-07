<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Movement;

class MovementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privileges:movements');
    }
    
    public function index() {
    	$movements = Movement::all();
    	return View('movements.index')->with('movements', $movements);
    }
}
