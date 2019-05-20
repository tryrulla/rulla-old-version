<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (AuthenticationException $e) {
            $auth = false;
            if (env('LOGIN_PROVIDER', 'saml2') === 'env'
                && getenv('upn')) {
                $email = getenv('upn');
                $username = strtolower(explode('@', $email)[0]);
                $realname = ucwords(str_replace('.', ' ', $username));

                $user = User::firstOrCreate([
                    'email' => $email,
                ], [
                    'email' => $email,
                    'username' => $username,
                    'name' => $realname,
                    'password' => '',
                ]);

                Auth::login($user);
                $auth = true;
            }

            if (! $auth) {
                throw $e;
            }
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route(env('LOGIN_PROVIDER', 'saml2') === 'saml2' ? 'saml_login' : 'login');
        }
    }
}
