<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Movement;

class MovementsController extends Controller
{
    public function index() {
    	$movements = Movement::all();
    	return View('movements.index')->with('movements', $movements);
    }
}
