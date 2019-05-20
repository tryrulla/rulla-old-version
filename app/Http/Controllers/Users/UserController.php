<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User
            ::usingSearchString($request->get('search', ''));

        return $request->has('all')
            ? $query->get()
            : $query->paginate(25);
    }

    public function show(User $user)
    {
        return response($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->validate([
            'name' => 'nullable|min:3',
        ]));

        return response($user);
    }
}
