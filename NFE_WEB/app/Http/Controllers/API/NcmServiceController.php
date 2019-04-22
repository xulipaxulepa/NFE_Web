<?php

namespace App\Http\Controllers\API;

use App\Model\Ncm;
use App\Model\NcmEnterprise;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class NcmServiceController extends Controller
{
    public function openCode(Request $request)
    {
        $this->validate($request, ['code' => 'required']);
        $ncm = NULL;
        if (!empty(\request('enterprise'))) {
            $ncm = NcmEnterprise::select('ncms.*')
                ->join('ncms', 'ncms.id', '=', 'ncm_enterprises.ncm')
                ->where('ncm_enterprises.code', \request('code'))
                ->where('ncm_enterprises.enterprise', \request('enterprise'))
                ->first();
        } else {
            $ncm = Ncm::where('main', TRUE)->where('main', TRUE)->where('code', \request('code'))->first();
        }
        return response()->json(['data' => $ncm]);
    }

    public function allSelect(Request $request)
    {
        $this->validate($request, [
            'select' => 'required',
            'enterprise' => 'required'
        ]);

        $ncms = Ncm::select('ncms.*')
            ->join('ncm_enterprises', 'ncms.id', '=', 'ncm_enterprises.ncm')
            ->where('ncm_enterprises.enterprise', \request('enterprise'))
            ->where('ncm_enterprises.status', TRUE)
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('ncm_enterprises.code', 'LIKE', '%' . $search . '%')
                        ->orWhere('ncm_enterprises.description', 'LIKE', '%' . $search . '%')
                        ->orWhere('ncm_enterprises.ipi', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('ncm_enterprises.code', 'ASC')->paginate(5);

        foreach ($ncms as $key => $value) {
            $ncmEnterprise = NcmEnterprise::where('ncm', $value->id)->where('enterprise', \request('enterprise'))->first();
            $value->code = $ncmEnterprise->code;
            $value->description = $ncmEnterprise->description;
            $value->ipi = $ncmEnterprise->ipi;
        }

        return ['count' => count($ncms), 'html' => View::make(\request('select'))->with('ncms', $ncms)->render()];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'enterprise' => 'required'
        ]);

        $ipi = NULL;
        $ipiCampo = \request('ipi');
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
        $ncm->code = \request('code');
        $ncm->description = \request('description');
        $ncm->ipi = $ipi;
        $ncm->main = FALSE;
        $ncm->save();

        $ncmEnterprise = new NcmEnterprise();
        $ncmEnterprise->code = $ncm->code;
        $ncmEnterprise->description = $ncm->description;
        $ncmEnterprise->ipi = $ncm->ipi;
        $ncmEnterprise->status = TRUE;
        $ncmEnterprise->ncm = $ncm->id;
        $ncmEnterprise->enterprise = \request('enterprise');
        $ncmEnterprise->save();

        return response()->json(['data' => $ncm]);
    }

    public function show(Request $request)
    {
        $this->validate($request, ['id' => 'required']);
        $ncm = Ncm::find(\request('id'));
        if (\request('enterprise')) {
            $ncmEnterprise = NcmEnterprise::where('ncm', $ncm->id)->where('enterprise', \request('enterprise'))->first();
            if (!is_null($ncmEnterprise)) {
                $ncm->code = $ncmEnterprise->code;
                $ncm->description = $ncmEnterprise->description;
                $ncm->ipi = $ncmEnterprise->ipi;
            }
        }
        return response()->json(['data' => $ncm]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'code' => 'required',
            'enterprise' => 'required'
        ]);

        $ipi = NULL;
        $ipiCampo = \request('ipi');
        for ($i = 0; $i < strlen($ipiCampo); $i++) {
            if (is_numeric($ipiCampo[$i])) {
                $ipi .= $ipiCampo[$i];
            } else {
                if ($ipiCampo[$i] == "." || $ipiCampo[$i] == ",") {
                    $ipi .= ".";
                }
            }
        }

        $ncm = Ncm::find(\request('id'));
        if (!$ncm->main) {
            $ncm->code = \request('code');
            $ncm->description = \request('description');
            $ncm->ipi = $ipi;
            $ncm->save();
        }

        $ncmEnterprise = NcmEnterprise::where('ncm', $ncm->id)->where('enterprise', \request('enterprise'))->first();
        if (is_null($ncmEnterprise)) {
            $ncmEnterprise = new NcmEnterprise();
            $ncmEnterprise->status = TRUE;
            $ncmEnterprise->ncm = $ncm->id;
            $ncmEnterprise->enterprise = \request('enterprise');
        }
        $ncmEnterprise->code = \request('code');
        $ncmEnterprise->description = \request('description');
        $ncmEnterprise->ipi = $ipi;
        $ncmEnterprise->save();

        return response()->json(['data' => $ncm]);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'enterprise' => 'required'
        ]);
        $ncm = Ncm::find(\request('id'));
        if (!$ncm->main) {
            $ncm->delete();
        } else {
            $products = Product::where('ncm', $ncm->id)->get();
            foreach ($products as $product) {
                $product->delete();
            }

            $ncmEnterprise = NcmEnterprise::where('ncm', $ncm->id)->where('enterprise', \request('enterprise'))->first();
            if (is_null($ncmEnterprise)) {
                $ncmEnterprise = new NcmEnterprise();
                $ncmEnterprise->ncm = $ncm->id;
                $ncmEnterprise->enterprise = \request('enterprise');
                $ncmEnterprise->code = $ncm->code;
                $ncmEnterprise->description = $ncm->description;
                $ncmEnterprise->ipi = $ncm->ipi;
            }
            $ncmEnterprise->status = FALSE;
            $ncmEnterprise->save();
        }
        return response()->json(['status' => 'OK']);
    }
}
