<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Cfop;
use App\Model\CfopEnterprise;
use App\Model\Ncm;
use App\Model\NcmEnterprise;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProductServiceController extends Controller
{
    public function allSelect(Request $request)
    {
        $this->validate($request, [
            'select' => 'required',
            'enterprise' => 'required'
        ]);
        $products = Product::where('enterprise', \request('enterprise'))
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('products.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('products.unit', 'LIKE', '%' . $search . '%')
                        ->orWhere('products.price', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('name', 'ASC')->paginate(3);
        return ['count' => count($products), 'html' => View::make(\request('select'))->with('products', $products)->render()];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'ncm' => 'required',
            'cfop' => 'required',
            'value' => 'required',
            'price' => 'required',
            'aliquota' => 'required',
            'ipi' => 'required',
            'unit' => 'required',
            'enterprise' => 'required'
        ]);

        $valueField = \request('value');
        $value = "";
        for ($v = 0; $v < strlen($valueField); $v++) {
            if (!is_numeric($valueField[$v]) && ($valueField[$v] == "," || $valueField[$v] == ".")) {
                $value .= ".";
            } else if (is_numeric($valueField[$v])) {
                $value .= $valueField[$v];
            }
        }

        $priceField = \request('price');
        $price = "";
        for ($v = 0; $v < strlen($priceField); $v++) {
            if (!is_numeric($priceField[$v]) && ($priceField[$v] == "," || $priceField[$v] == ".")) {
                $price .= ".";
            } else if (is_numeric($priceField[$v])) {
                $price .= $priceField[$v];
            }
        }

        $aliquotaField = \request('aliquota');
        $aliquota = "";
        for ($v = 0; $v < strlen($aliquotaField); $v++) {
            if (!is_numeric($aliquotaField[$v]) && ($aliquotaField[$v] == "," || $aliquotaField[$v] == ".")) {
                $aliquota .= ".";
            } else if (is_numeric($aliquotaField[$v])) {
                $aliquota .= $aliquotaField[$v];
            }
        }

        $ipiField = \request('ipi');
        $ipi = "";
        for ($v = 0; $v < strlen($ipiField); $v++) {
            if (!is_numeric($ipiField[$v]) && ($ipiField[$v] == "," || $ipiField[$v] == ".")) {
                $ipi .= ".";
            } else if (is_numeric($ipiField[$v])) {
                $ipi .= $ipiField[$v];
            }
        }

        $product = new Product();
        $product->name = \request('name');
        $product->ncm = \request('ncm');
        $product->cfop = \request('cfop');
        $product->unit = \request('unit');
        $product->value = $value;
        $product->price = $price;
        $product->aliquota = $aliquota;
        $product->ipi = $ipi;
        $product->photo = NULL;
        $product->photo_mini = NULL;
        $product->enterprise = \request('enterprise');
        $product->save();

        return response(['data' => $product]);
    }

    public function show(Request $request)
    {
        $this->validate($request, ['id' => 'required']);
        $product = Product::find(\request('id'));

        $ncm = Ncm::find($product->ncm);
        $ncmEnterprise = NcmEnterprise::where('ncm', $ncm->id)->where('enterprise', $product->enterprise)->first();
        if(is_null($ncmEnterprise)) {
            $product->ncm_str = $ncm->code . (!is_null($ncm->description) ? " - " . $ncm->description : "");
        } else {
            $product->ncm_str = $ncmEnterprise->code . (!is_null($ncmEnterprise->description) ? " - " . $ncmEnterprise->description : "");
        }

        $cfop = Cfop::find($product->cfop);
        $cfopEnterprise = CfopEnterprise::where('cfop', $cfop->id)->where('enterprise', $product->enterprise)->first();
        if(is_null($cfopEnterprise)) {
            $product->cfop_str = $cfop->code . (!is_null($cfop->description) ? " - " . $cfop->description : "");
        } else {
            $product->cfop_str = $cfopEnterprise->code . (!is_null($cfopEnterprise->description) ? " - " . $cfopEnterprise->description : "");
        }

        return response()->json(['data' => $product]);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, ['id' => 'required']);
        $product = Product::find(\request('id'));
        $product->delete();
        return response()->json(['status' => 'OK']);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'ncm' => 'required',
            'cfop' => 'required',
            'value' => 'required',
            'price' => 'required',
            'aliquota' => 'required',
            'ipi' => 'required',
            'unit' => 'required'
        ]);

        $valueField = \request('value');
        $value = "";
        for ($v = 0; $v < strlen($valueField); $v++) {
            if (!is_numeric($valueField[$v]) && ($valueField[$v] == "," || $valueField[$v] == ".")) {
                $value .= ".";
            } else if (is_numeric($valueField[$v])) {
                $value .= $valueField[$v];
            }
        }

        $priceField = \request('price');
        $price = "";
        for ($v = 0; $v < strlen($priceField); $v++) {
            if (!is_numeric($priceField[$v]) && ($priceField[$v] == "," || $priceField[$v] == ".")) {
                $price .= ".";
            } else if (is_numeric($priceField[$v])) {
                $price .= $priceField[$v];
            }
        }

        $aliquotaField = \request('aliquota');
        $aliquota = "";
        for ($v = 0; $v < strlen($aliquotaField); $v++) {
            if (!is_numeric($aliquotaField[$v]) && ($aliquotaField[$v] == "," || $aliquotaField[$v] == ".")) {
                $aliquota .= ".";
            } else if (is_numeric($aliquotaField[$v])) {
                $aliquota .= $aliquotaField[$v];
            }
        }

        $ipiField = \request('ipi');
        $ipi = "";
        for ($v = 0; $v < strlen($ipiField); $v++) {
            if (!is_numeric($ipiField[$v]) && ($ipiField[$v] == "," || $ipiField[$v] == ".")) {
                $ipi .= ".";
            } else if (is_numeric($ipiField[$v])) {
                $ipi .= $ipiField[$v];
            }
        }

        $product = Product::find(\request('id'));
        $product->name = \request('name');
        $product->ncm = \request('ncm');
        $product->cfop = \request('cfop');
        $product->unit = \request('unit');
        $product->value = $value;
        $product->price = $price;
        $product->aliquota = $aliquota;
        $product->ipi = $ipi;
        $product->save();

        return response(['data' => $product]);
    }
}