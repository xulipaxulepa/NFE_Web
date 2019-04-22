<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Cst;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CstController extends Controller
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
        return View::make('cst.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->permission('ROLE_ADMIN');
        return View::make('cst.create');
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
        $cst = new Cst();
        $cst->code = Input::get('code');
        $cst->description = Input::get('description');
        $cst->main = TRUE;
        $cst->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('cst/create');
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
        $cst = Cst::find($id);
        return View::make('cst.edit')->with('cst', $cst);
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
        $cst = Cst::find($id);
        $cst->code = Input::get('code');
        $cst->description = Input::get('description');
        $cst->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('cst/' . $id . '/edit');
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
        $cst = Cst::find($id);
        $cst->delete();
        return response()->json(['status' => 'OK']);
    }
}