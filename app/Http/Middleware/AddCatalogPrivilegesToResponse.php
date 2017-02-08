<?php

namespace App\Http\Middleware;

use Closure;

class AddCatalogPrivilegesToResponse
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
        $response = $next($request);

        $collection = json_decode($response->original);
        $collection = json_encode(array_merge(['data' => $collection], ['privileges' => account()->get_catalog_privileges($role)] ));
        $response->setContent($collection);

        return $response;
    }
}
