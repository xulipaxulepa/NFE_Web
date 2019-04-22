<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\UserEnterprise;
use Illuminate\Http\Request;

class UserEnterpriseServiceController extends Controller
{
    public function openEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'enterprise' => 'required'
        ]);
        $userEnterprise = UserEnterprise::select('user_enterprises.*')
            ->join('users', 'users.id', '=', 'user_enterprises.user')
            ->where('user_enterprises.enterprise', \request('enterprise'))
            ->where('users.email', \request('email'))->first();
        return response()->json(['data' => $userEnterprise]);
    }
}