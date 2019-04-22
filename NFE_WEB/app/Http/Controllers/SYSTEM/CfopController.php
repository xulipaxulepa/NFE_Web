<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Cfop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CfopController extends Controller
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
        return View::make('cfop.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->permission('ROLE_ADMIN');
        return View::make('cfop.create');
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
        $cfop = new Cfop();
        $cfop->code = Input::get('code');
        $cfop->description = Input::get('description');
        $cfop->main = TRUE;
        $cfop->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('cfop/create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::user()->permission('ROLE_ADMIN');
        $cfop = Cfop::find($id);
        return View::make('cfop.edit')->with('cfop', $cfop);
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
        Auth::user()->permission('ROLE_ADMIN');
        $cfop = Cfop::find($id);
        $cfop->code = Input::get('code');
        $cfop->description = Input::get('description');
        $cfop->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('cfop/' . $id . '/edit');
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
        $cfop = Cfop::find($id);
        $cfop->delete();
        return response()->json(['status' => 'OK']);
    }
}