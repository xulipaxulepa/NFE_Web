<?php

namespace App\Http\Controllers\SYSTEM;

use App\Http\Controllers\Controller;
use App\Model\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verify_profile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->permission('ROLE_ADMIN');
        return View::make('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->permission('ROLE_ADMIN');
        return View::make('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->permission('ROLE_ADMIN');
        $user = new User();
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->password = bcrypt(Input::get('password'));
        $user->status = TRUE;
        $user->save();

        $role = new Role();
        $role->level = 'ROLE_ADMIN';
        $role->user = $user->id;
        $role->save();

        Session::flash('success', __("messages.success"));
        return Redirect::to('user/create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return View::make('user.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->password = bcrypt(Input::get('password'));
        $user->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('user/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->permission('ROLE_ADMIN');
        $user = User::find($id);
        $user->delete();
        return response()->json(['status' => 'OK']);
    }

    public function status($id)
    {
        Auth::user()->permission('ROLE_ADMIN');
        $user = User::find($id);
        $user->status = !$user->status;
        $user->save();
        return response()->json(['status' => 'OK']);
    }
}