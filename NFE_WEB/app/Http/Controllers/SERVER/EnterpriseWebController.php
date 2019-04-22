<?php

namespace App\Http\Controllers\SERVER;

use App\Model\Enterprise;
use App\Model\UserEnterprise;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class EnterpriseWebController extends Controller
{
    public function allEnterprise(Request $request)
    {
        $this->validate($request, ['user' => 'required']);
        $enterprises = Enterprise::where('user', \request('user'))
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('social_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('fantasy_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('cnpj', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('id', 'ASC')->get();
        return View::make('enterprise.list_enterprises_single_enterprise')->with('enterprises', $enterprises)->render();
    }

    public function all(Request $request)
    {
        $enterprises = Enterprise::select('enterprises.*')->join('users', 'users.id', '=', 'enterprises.user')
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('social_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('fantasy_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('cnpj', 'LIKE', '%' . $search . '%')
                        ->orWhere('state_registration', 'LIKE', '%' . $search . '%')
                        ->orWhere('state', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('social_name', 'ASC')->orderBy('fantasy_name', 'ASC')->paginate(5);
        return ['count' => count($enterprises), 'html' => View::make('enterprise.list_enterprises')->with('enterprises', $enterprises)->render()];
    }

    public function allLimits(Request $request)
    {
        $users = User::select('users.*')->join('roles', 'users.id', '=', 'roles.user')
            ->where('roles.level', 'ROLE_ENTERPRISE')
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('users.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('users.name', 'ASC')->orderBy('users.email', 'ASC')->paginate(5);
        return ['count' => count($users), 'html' => View::make('enterpriselimit.list_enterprise_limits')->with('users', $users)->render()];
    }

    public function allManager(Request $request)
    {
        $this->validate($request, ['user' => 'required']);
        $enterprises = UserEnterprise::select('enterprises.*')
            ->join('enterprises', 'enterprises.id', '=', 'user_enterprises.enterprise')
            ->where('user_enterprises.user', \request('user'))
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('enterprises.social_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('enterprises.fantasy_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('enterprises.cnpj', 'LIKE', '%' . $search . '%');
                }
            })
            ->orderBy('enterprises.social_name', 'ASC')
            ->orderBy('enterprises.fantasy_name', 'ASC')->get();
        return View::make('enterprise.list_enterprises_single_manager')->with('enterprises', $enterprises)->with('user_id', \request('user'))->render();
    }
}
