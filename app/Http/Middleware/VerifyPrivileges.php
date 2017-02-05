<?php

namespace App\Http\Middleware;

use Closure;

class VerifyPrivileges
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
        $currentAction = parseActionName($request->route()->getActionName());
        $account = account();
        
        if(!$account->has_privilege(config('constants.' . $role . '.' . $currentAction))) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
