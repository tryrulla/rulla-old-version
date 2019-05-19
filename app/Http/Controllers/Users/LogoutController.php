<?php

namespace App\Http\Controllers\Users;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        if (env('LOGIN_PROVIDER', 'saml2') !== 'env') {
            $this->guard()->logout();
            $request->session()->invalidate();
        }

        return redirect('/');
    }

    private function guard()
    {
        return Auth::guard();
    }
}
