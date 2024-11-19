<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            # if guard is authenticated
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard);
                return $next($request);
            }
        }

        # Handle unauthenticated session
        $this->unauthenticated($guards);
    }

    /**
     * Function to handle unauthenticated request
     * @param array $guards
     */
    protected function unauthenticated(array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated',
            $guards,
            $this->redirectTo()
        );
    }

    /**
     * Function to redirect based on route
     */
    protected function redirectTo()
    {
        # For super admin
        if (Route::is('super-admin.*')) {
            session()->flash('error', 'You must be logged in as a super admin to access this page.');
            return route('super-admin.login');
        }

        # For master
        if (Route::is('master.*')) {
            session()->flash('error', 'You must be logged in as a master to access this page.');
            return route('master.login');
        }

        # For admin
        if (Route::is('admin.*')) {
            session()->flash('error', 'You must be logged in as an admin to access this page.');
            return route('admin.login');
        }

        # For normal user
        session()->flash('error', 'You must be logged in to access this page.');
        return route('login');
    }
}