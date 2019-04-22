<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Ncm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class NcmController extends Controller
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
        return View::make('ncm.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->permission('ROLE_ADMIN');
        return View::make('ncm.create');
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
        $ipi = NULL;
        $ipiCampo = Input::get('ipi');
        for ($i = 0; $i < strlen($ipiCampo); $i++) {
            if (is_numeric($ipiCampo[$i])) {
                $ipi .= $ipiCampo[$i];
            } else {
                if ($ipiCampo[$i] == "." || $ipiCampo[$i] == ",") {
                    $ipi .= ".";
                }
            }
        }
        $ncm = new Ncm();
        $ncm->code = Input::get('code');
        $ncm->description = Input::get('description');
        $ncm->ipi = $ipi;
        $ncm->main = TRUE;
        $ncm->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('ncm/create');
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
        $ncm = Ncm::find($id);
        return View::make('ncm.edit')->with('ncm', $ncm);
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
        $ipi = NULL;
        $ipiCampo = Input::get('ipi');
        for ($i = 0; $i < strlen($ipiCampo); $i++) {
            if (is_numeric($ipiCampo[$i])) {
                $ipi .= $ipiCampo[$i];
            } else {
                if ($ipiCampo[$i] == "." || $ipiCampo[$i] == ",") {
                    $ipi .= ".";
                }
            }
        }
        $ncm = Ncm::find($id);
        $ncm->code = Input::get('code');
        $ncm->description = Input::get('description');
        $ncm->ipi = $ipi;
        $ncm->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('ncm/' . $id . '/edit');
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
        $ncm = Ncm::find($id);
        $ncm->delete();
        return response()->json(['status' => 'OK']);
    }
}