<?php

namespace App\Http\Controllers\SERVER;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class UserWebController extends Controller
{
    public function all(Request $request)
    {
        $this->validate($request, ['user' => 'required']);
        $users = User::select('users.*')->join('roles', 'users.id', '=', 'roles.user')
            ->whereNotIn('users.id', [\request('user')])
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('users.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                        ->orWhere('roles.level', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('users.name', 'ASC')->orderBy('users.email', 'ASC')->paginate(5);
        return ['count' => count($users), 'html' => View::make('user.list_users')->with('users', $users)->render()];
    }
}
