<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Cfop;
use App\Model\Ncm;
use App\Model\Cst;
use App\Model\CfopEnterprise;
use App\Model\NcmEnterprise;
use App\Model\CstEnterprise;
use App\Model\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserServiceController extends Controller
{
    public function openEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required']);
        $user = User::where('email', \request('email'))->first();
        if(!empty(\request('role')) && !is_null($user)) {
            $role = Role::where('level', \request('role'))->where('user', $user->id)->first();
            if(!is_null($role)){
                $user = NULL;
            }
        }
        return response()->json(['data' => $user]);
    }

    public function openEmailPassword(Request $request)
    {
        $this->validate($request, ['email' => 'required', 'password' => 'required']);
        $credentials = $request->only('email', 'password');
        $user = NULL;
        if (Auth::attempt($credentials)) {
            $user = User::where('email', \request('email'))->first();
        }
        return response()->json(['data' => $user]);
    }
    
     public function processAjax(Request $request){
        $this->validate($request, ['enterprise' => 'required']);
        $cfos = Cfop::where('main', TRUE)->get();
        foreach($cfos as $cfop){
            $cfopEnterprise = CfopEnterprise::where('enterprise', \request('enterprise'))->where('cfop', $cfop->id)->first();
            if (is_null($cfopEnterprise)) {
                $cfopEnterprise = new CfopEnterprise();
                $cfopEnterprise->cfop = $cfop->id;
                $cfopEnterprise->enterprise = \request('enterprise');
                $cfopEnterprise->code = $cfop->code;
                $cfopEnterprise->description = $cfop->description;
                $cfopEnterprise->status = TRUE;
                $cfopEnterprise->save();
            }
        }

        $ncms = Ncm::where('main', TRUE)->get();
        foreach($ncms as $ncm){
            $ncmEnterprise = NcmEnterprise::where('enterprise', \request('enterprise'))->where('ncm', $ncm->id)->first();
            if (is_null($ncmEnterprise)) {
                $ncmEnterprise = new NcmEnterprise();
                $ncmEnterprise->ncm = $ncm->id;
                $ncmEnterprise->enterprise = \request('enterprise');
                $ncmEnterprise->code = $ncm->code;
                $ncmEnterprise->description = $ncm->description;
                $ncmEnterprise->ipi = $ncm->ipi;
                $ncmEnterprise->status = TRUE;
                $ncmEnterprise->save();
            }
        }

        $csts = Cst::where('main', TRUE)->get();
        foreach($csts as $cst){
            $cstEnterprise = CstEnterprise::where('enterprise', \request('enterprise'))->where('cst', $cst->id)->first();
            if (is_null($cstEnterprise)) {
                $cstEnterprise = new CstEnterprise();
                $cstEnterprise->cst = $cst->id;
                $cstEnterprise->enterprise = \request('enterprise');
                $cstEnterprise->code = $cst->code;
                $cstEnterprise->description = $cst->description;
                $cstEnterprise->status = TRUE;
                $cstEnterprise->save();
            }
        }
    }
}
