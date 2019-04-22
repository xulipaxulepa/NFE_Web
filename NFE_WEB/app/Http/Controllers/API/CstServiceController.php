<?php

namespace App\Http\Controllers\API;

use App\Model\Cst;
use App\Model\CstEnterprise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CstServiceController extends Controller
{
    public function openCode(Request $request)
    {
        $this->validate($request, ['code' => 'required']);
        $cst = NULL;
        if (!empty(\request('enterprise'))) {
            $cst = CstEnterprise::select('csts.*')
                ->join('csts', 'csts.id', '=', 'cst_enterprises.cst')
                ->where('cst_enterprises.code', \request('code'))
                ->where('cst_enterprises.enterprise', \request('enterprise'))
                ->first();
        } else {
            $cst = Cst::where('main', TRUE)->where('main', TRUE)->where('code', \request('code'))->first();
        }
        return response()->json(['data' => $cst]);
    }

    public function allSelect(Request $request)
    {
        $this->validate($request, [
            'select' => 'required',
            'enterprise' => 'required'
        ]);

        $csts = Cst::select('csts.*')
            ->join('cst_enterprises', 'csts.id', '=', 'cst_enterprises.cst')
            ->where('cst_enterprises.enterprise', \request('enterprise'))
            ->where('cst_enterprises.status', TRUE)
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('cst_enterprises.code', 'LIKE', '%' . $search . '%')
                        ->orWhere('cst_enterprises.description', 'LIKE', '%' . $search . '%')
                        ->orWhere('cst_enterprises.ipi', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('cst_enterprises.code', 'ASC')->paginate(5);

        foreach ($csts as $key => $value) {
            $cstEnterprise = CstEnterprise::where('cst', $value->id)->where('enterprise', \request('enterprise'))->first();
            $value->code = $cstEnterprise->code;
            $value->description = $cstEnterprise->description;
            $value->ipi = $cstEnterprise->ipi;
        }

        return ['count' => count($csts), 'html' => View::make(\request('select'))->with('csts', $csts)->render()];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'enterprise' => 'required'
        ]);

        $cst = new Cst();
        $cst->code = \request('code');
        $cst->description = \request('description');
        $cst->main = FALSE;
        $cst->save();

        $cstEnterprise = new CstEnterprise();
        $cstEnterprise->code = $cst->code;
        $cstEnterprise->description = $cst->description;
        $cstEnterprise->status = TRUE;
        $cstEnterprise->cst = $cst->id;
        $cstEnterprise->enterprise = \request('enterprise');
        $cstEnterprise->save();

        return response()->json(['data' => $cst]);
    }

    public function show(Request $request)
    {
        $this->validate($request, ['id' => 'required']);
        $cst = Cst::find(\request('id'));
        if (\request('enterprise')) {
            $cstEnterprise = CstEnterprise::where('cst', $cst->id)->where('enterprise', \request('enterprise'))->first();
            if (!is_null($cstEnterprise)) {
                $cst->code = $cstEnterprise->code;
                $cst->description = $cstEnterprise->description;
            }
        }
        return response()->json(['data' => $cst]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'code' => 'required',
            'enterprise' => 'required'
        ]);

        $cst = Cst::find(\request('id'));
        if (!$cst->main) {
            $cst->code = \request('code');
            $cst->description = \request('description');
            $cst->save();
        }

        $cstEnterprise = CstEnterprise::where('cst', $cst->id)->where('enterprise', \request('enterprise'))->first();
        if (is_null($cstEnterprise)) {
            $cstEnterprise = new CstEnterprise();
            $cstEnterprise->status = TRUE;
            $cstEnterprise->cst = $cst->id;
            $cstEnterprise->enterprise = \request('enterprise');
        }
        $cstEnterprise->code = \request('code');
        $cstEnterprise->description = \request('description');
        $cstEnterprise->save();

        return response()->json(['data' => $cst]);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'enterprise' => 'required'
        ]);
        $cst = Cst::find(\request('id'));
        if (!$cst->main) {
            $cst->delete();
        } else {
            $cstEnterprise = CstEnterprise::where('cst', $cst->id)->where('enterprise', \request('enterprise'))->first();
            if (is_null($cstEnterprise)) {
                $cstEnterprise = new CstEnterprise();
                $cstEnterprise->cst = $cst->id;
                $cstEnterprise->enterprise = \request('enterprise');
                $cstEnterprise->code = $cst->code;
                $cstEnterprise->description = $cst->description;
            }
            $cstEnterprise->status = FALSE;
            $cstEnterprise->save();
        }
        return response()->json(['status' => 'OK']);
    }
}