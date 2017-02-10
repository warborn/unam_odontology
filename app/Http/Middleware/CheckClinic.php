<?php

namespace App\Http\Middleware;

use Closure;

class CheckClinic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $action_param = ['course' => 'courses', 'format' => 'formats'];

        $resource = $request->route($role);

        if($resource->clinic_id != clinic()->clinic_id) {
            return redirect()->route($action_param[$role] . '.index');
        }

        return $next($request);
    }
}
