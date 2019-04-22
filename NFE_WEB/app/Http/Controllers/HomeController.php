<?php

namespace App\Http\Controllers;

use App\Model\Cfop;
use App\Model\CfopEnterprise;
use App\Model\Cst;
use App\Model\CstEnterprise;
use App\Model\Enterprise;
use App\Model\Ncm;
use App\Model\NcmEnterprise;
use App\Model\Profile;
use App\Model\Soon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verify_profile');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $soon = Soon::first();

        $profile = Profile::where('user', Auth::id())->first();
        if (is_null($profile)) {
            return Redirect::to('profile/create');
        }

        if (Auth::user()->permissionBoolean('ROLE_ENTERPRISE')) {
            $enterprise = Enterprise::where('user', Auth::id())->first();
            if (is_null($enterprise)) {
                return Redirect::to('enterprise/create');
            }
        }
        if(Session::has('enterprise') && !Session::has('imported')){
                Session::put('imported', TRUE);
                return Redirect::to('process');
        }

        if ((Auth::user()->permissionBoolean('ROLE_ENTERPRISE') || Auth::user()->permissionBoolean('ROLE_MANAGER')) && !Session::has('enterprise')) {
            return Redirect::to('enterprise');
        }

        return View::make('home')->with('soon', $soon);
    }

    public function process(){
        return View::make('process');
    }

    public function processAjax(Request $request){
        $this->validate($request, ['enterprise' => 'required']);
        $cfos = Cfop::where('main', TRUE)->get();
        foreach($cfos as $cfop){
            $cfopEnterprise = CfopEnterprise::where('enterprise', Session::get('enterprise')->id)->where('cfop', $cfop->id)->first();
            if (is_null($cfopEnterprise)) {
                $cfopEnterprise = new CfopEnterprise();
                $cfopEnterprise->cfop = $cfop->id;
                $cfopEnterprise->enterprise = Session::get('enterprise')->id;
                $cfopEnterprise->code = $cfop->code;
                $cfopEnterprise->description = $cfop->description;
                $cfopEnterprise->status = TRUE;
                $cfopEnterprise->save();
            }
        }

        $ncms = Ncm::where('main', TRUE)->get();
        foreach($ncms as $ncm){
            $ncmEnterprise = NcmEnterprise::where('enterprise', Session::get('enterprise')->id)->where('ncm', $ncm->id)->first();
            if (is_null($ncmEnterprise)) {
                $ncmEnterprise = new NcmEnterprise();
                $ncmEnterprise->ncm = $ncm->id;
                $ncmEnterprise->enterprise = Session::get('enterprise')->id;
                $ncmEnterprise->code = $ncm->code;
                $ncmEnterprise->description = $ncm->description;
                $ncmEnterprise->ipi = $ncm->ipi;
                $ncmEnterprise->status = TRUE;
                $ncmEnterprise->save();
            }
        }

        $csts = Cst::where('main', TRUE)->get();
        foreach($csts as $cst){
            $cstEnterprise = CstEnterprise::where('enterprise', Session::get('enterprise')->id)->where('cst', $cst->id)->first();
            if (is_null($cstEnterprise)) {
                $cstEnterprise = new CstEnterprise();
                $cstEnterprise->cst = $cst->id;
                $cstEnterprise->enterprise = Session::get('enterprise')->id;
                $cstEnterprise->code = $cst->code;
                $cstEnterprise->description = $cst->description;
                $cstEnterprise->status = TRUE;
                $cstEnterprise->save();
            }
        }
    }

}