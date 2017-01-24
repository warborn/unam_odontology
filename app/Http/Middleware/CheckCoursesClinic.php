<?php

namespace App\Http\Middleware;

use Closure;

class CheckCoursesClinic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $course = $request->route('course');

        if($course->clinic_id != clinic()->clinic_id) {
            return redirect()->route('courses.index');
        }

        return $next($request);
    }
}
