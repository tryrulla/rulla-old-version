<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, User $user)
    {
        session()->flash('status', 'Welcome back, ' . $user->username . '!');
    }

    protected function loggedOut(Request $request)
    {
        return redirect($this->redirectTo);
    }

    public function username()
    {
        // support authentication with both username and email

        $identity = request()->get('identity');
        $fieldName = filter_var($identity, FILTER_VALIDATE_EMAIL)
            ? 'email' : 'username';

        request()->merge([$fieldName => $identity]);
        return $fieldName;
    }
}
