<?php

namespace App\Http\Controllers\SERVER;

use App\Model\UserEnterprise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class UserEnterpriseWebController extends Controller
{
    public function all(Request $request)
    {
        $users = UserEnterprise::select('users.*')
            ->join('users', 'users.id', '=', 'user_enterprises.user')
            ->where('user_enterprises.enterprise', \request('enterprise'))
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('users.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('users.name', 'ASC')->orderBy('users.email', 'ASC')->paginate(5);
        return ['count' => count($users), 'html' => View::make('userenterprise.list_users')->with('users', $users)->render()];
    }
}
