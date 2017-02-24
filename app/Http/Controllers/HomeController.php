<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(account()->has_role('super_user')) {
            return redirect()->route('accounts.index');
        } else if(account()->has_role('administrator')) {
            return redirect()->route('courses.index');
        } else if(account()->has_role('teacher') && account()->has_profile('teacher')) {
            return redirect()->route('teachers.index_courses');
        } else if(account()->has_role('intern') && account()->has_profile('intern')) {
            return redirect()->route('formats.index');
        } else if(account()->has_role('student') && account()->has_profile('student')) {
            return redirect()->route('students.index_courses');
        }

        return redirect()->route('users.profile');
    }
}
