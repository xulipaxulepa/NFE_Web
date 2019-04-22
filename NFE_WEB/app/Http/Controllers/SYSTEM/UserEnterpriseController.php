<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Role;
use App\Model\UserEnterprise;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserEnterpriseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verify_profile');
        $this->middleware('verify_enterprise');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->permission('ROLE_ENTERPRISE');
        return View::make('userenterprise.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->permission('ROLE_ENTERPRISE');
        return View::make('userenterprise.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->permission('ROLE_ENTERPRISE');
        $user = User::where('email', \request('email'))->first();
        if (is_null($user)) {
            $user = new User();
            $user->name = Input::get('name');
            $user->email = Input::get('email');
            $user->password = bcrypt(Input::get('password'));
            $user->status = TRUE;
            $user->save();

            $role = new Role();
            $role->level = 'ROLE_MANAGER';
            $role->user = $user->id;
            $role->save();
        }
        $userenterprise = UserEnterprise::where('user', $user->id)->where('enterprise', Session::get('enterprise')->id)->first();
        if (is_null($userenterprise)) {
            $userenterprise = new UserEnterprise();
            $userenterprise->user = $user->id;
            $userenterprise->enterprise = Session::get('enterprise')->id;
            $userenterprise->save();
            Session::flash('success', __("messages.success"));
        }
        return Redirect::to('userenterprise/create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->permission('ROLE_ENTERPRISE');
        $user = User::find($id);
        $user->delete();
        return response()->json(['status' => 'OK']);
    }
}