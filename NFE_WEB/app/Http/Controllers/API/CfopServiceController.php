<?php

namespace App\Http\Controllers\API;

use App\Model\Cfop;
use App\Model\CfopEnterprise;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CfopServiceController extends Controller
{
    public function openCode(Request $request)
    {
        $this->validate($request, ['code' => 'required']);
        $cfop = NULL;
        if (!empty(\request('enterprise'))) {
            $cfop = CfopEnterprise::select('cfops.*')
                ->join('cfops', 'cfops.id', '=', 'cfop_enterprises.cfop')
                ->where('cfop_enterprises.code', \request('code'))
                ->where('cfop_enterprises.enterprise', \request('enterprise'))
                ->first();
        } else {
            $cfop = Cfop::where('main', TRUE)->where('main', TRUE)->where('code', \request('code'))->first();
        }
        return response()->json(['data' => $cfop]);
    }

    public function allSelect(Request $request)
    {
        $this->validate($request, [
            'select' => 'required',
            'enterprise' => 'required'
        ]);

        $cfops = Cfop::select('cfops.*')
            ->join('cfop_enterprises', 'cfops.id', '=', 'cfop_enterprises.cfop')
            ->where('cfop_enterprises.enterprise', \request('enterprise'))
            ->where('cfop_enterprises.status', TRUE)
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('cfop_enterprises.code', 'LIKE', '%' . $search . '%')
                        ->orWhere('cfop_enterprises.description', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('cfop_enterprises.code', 'ASC')->paginate(5);

        foreach ($cfops as $key => $value) {
            $cfopEnterprise = CfopEnterprise::where('cfop', $value->id)->where('enterprise', \request('enterprise'))->first();
            $value->code = $cfopEnterprise->code;
            $value->description = $cfopEnterprise->description;
        }

        return ['count' => count($cfops), 'html' => View::make(\request('select'))->with('cfops', $cfops)->render()];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'enterprise' => 'required'
        ]);

        $cfop = new Cfop();
        $cfop->code = \request('code');
        $cfop->description = \request('description');
        $cfop->main = FALSE;
        $cfop->save();

        $cfopEnterprise = new CfopEnterprise();
        $cfopEnterprise->code = $cfop->code;
        $cfopEnterprise->description = $cfop->description;
        $cfopEnterprise->status = TRUE;
        $cfopEnterprise->cfop = $cfop->id;
        $cfopEnterprise->enterprise = \request('enterprise');
        $cfopEnterprise->save();

        return response()->json(['data' => $cfop]);
    }

    public function show(Request $request)
    {
        $this->validate($request, ['id' => 'required']);
        $cfop = Cfop::find(\request('id'));
        if (\request('enterprise')) {
            $cfopEnterprise = CfopEnterprise::where('cfop', $cfop->id)->where('enterprise', \request('enterprise'))->first();
            if (!is_null($cfopEnterprise)) {
                $cfop->code = $cfopEnterprise->code;
                $cfop->description = $cfopEnterprise->description;
            }
        }
        return response()->json(['data' => $cfop]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'code' => 'required',
            'enterprise' => 'required'
        ]);

        $cfop = Cfop::find(\request('id'));
        if (!$cfop->main) {
            $cfop->code = \request('code');
            $cfop->description = \request('description');
            $cfop->save();
        }

        $cfopEnterprise = CfopEnterprise::where('cfop', $cfop->id)->where('enterprise', \request('enterprise'))->first();
        if (is_null($cfopEnterprise)) {
            $cfopEnterprise = new CfopEnterprise();
            $cfopEnterprise->status = TRUE;
            $cfopEnterprise->cfop = $cfop->id;
            $cfopEnterprise->enterprise = \request('enterprise');
        }
        $cfopEnterprise->code = \request('code');
        $cfopEnterprise->description = \request('description');
        $cfopEnterprise->save();

        return response()->json(['data' => $cfop]);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'enterprise' => 'required'
        ]);
        $cfop = Cfop::find(\request('id'));
        if (!$cfop->main) {
            $cfop->delete();
        } else {
            $products = Product::where('cfop', $cfop->id)->get();
            foreach ($products as $product) {
                $product->delete();
            }

            $cfopEnterprise = CfopEnterprise::where('cfop', $cfop->id)->where('enterprise', \request('enterprise'))->first();
            if (is_null($cfopEnterprise)) {
                $cfopEnterprise = new CfopEnterprise();
                $cfopEnterprise->cfop = $cfop->id;
                $cfopEnterprise->enterprise = \request('enterprise');
                $cfopEnterprise->code = $cfop->code;
                $cfopEnterprise->description = $cfop->description;
            }
            $cfopEnterprise->status = FALSE;
            $cfopEnterprise->save();
        }
        return response()->json(['status' => 'OK']);
    }
}