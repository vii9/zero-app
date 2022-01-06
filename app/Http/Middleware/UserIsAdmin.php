<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Constant\ApiStatus;
use App\Traits\ApiRoleHelper;


class UserIsAdmin
{

    use ApiRoleHelper;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ( ! $this->isUserHasRoleCEO()) {
            return apiError(ApiStatus::CREDENTIAL_ERROR, 'Unauthorized!');
        }

        return $next($request);
    }
}
