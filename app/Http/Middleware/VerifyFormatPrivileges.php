<?php

namespace App\Http\Middleware;

use Closure;

class VerifyFormatPrivileges
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
        $currentAction = parseActionName($request->route()->getActionName());
        $account = account();

        $actions = ['index'           => 'CULFMA',
                    'create'          => 'ALTFMA',
                    'store'           => 'ALTFMA',
                    'show'            => 'CULFMA',
                    'edit'            => 'MFIFMA',
                    'update'          => 'MFIFMA',
                    'store_student'   => 'AGNEDIFMA',
                    'destroy_student' => 'BAJEDIFMA'];

        if(!$account->has_privilege($actions[$currentAction])) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
