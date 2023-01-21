<?php

namespace App\Http\Middleware;

use App\Components\Util;
use App\Services\Auth\LeiturinhaJwtGuard;
use App\Services\ResponseService;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {

        try {

            $user = JWTAuth::parseToken()->authenticate();
            $leiturinhaGuard = new LeiturinhaJwtGuard($request->bearerToken());

            if ($leiturinhaGuard->validate()) {
                $leiturinhaGuard->login();
            }

        } catch (Exception $exception) {
            return $exception->getMessage();
        }

        return parent::handle($request, $next, $guards);

    }
}
