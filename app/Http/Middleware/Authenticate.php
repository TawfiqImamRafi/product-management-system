<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected $guards;
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
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access',
            ], 401);
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        if ($this->guards && $this->guards[0] === 'api') {
            if ($this->auth->guard('api')->guest()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access',
                ]);
            }
        } elseif ($this->guards && $this->guards[0] === 'admin') {
            if ($this->auth->guard('admin')->guest()) {
                return redirect()->route('admin.login');
            }
        } else {
            if ($this->auth->guard()->guest()) {
                return redirect()->route('login');
            }
        }

        return $next($request);

    }

}
