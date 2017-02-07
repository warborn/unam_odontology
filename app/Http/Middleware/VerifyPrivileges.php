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
        list($controller, $action) = parseCurrentRoute($request);
        $account = account();

        // Map controller name to role and profile that needs to have the account in order to work
        $roles = [
            'TeachersController' => 'teacher',
            'StudentsController' => 'student',
            'FormatsController' => 'intern'
        ];

        if(isset($roles[$controller])) {
            $current_role = $roles[$controller];
            // Redirect if user request create/store actions from formats controller and doesn't have an intern profile
            // or doesn't have intern, teacher or student profile at all
            if(($current_role == 'intern' && in_array($action, ['create', 'store']) && !$account->has_profile($current_role)) || 
                !$account->has_profile($current_role)) {
                return redirect()->route('home');
            }
        }

        if(!$account->has_privilege(config('constants.' . $role . '.' . $action))) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
