<?php

namespace App\Http\Middleware;

use Closure;

class CheckAccountOwner
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
        $account = \App\Account::from($request->route('user')->user_id, clinic()->clinic_id);

        if($account->is(account()) || $account->is_patient() || !account()->can_action_over($account)) {
            return redirect()->route('accounts.index');
        }

        return $next($request);
    }
}
