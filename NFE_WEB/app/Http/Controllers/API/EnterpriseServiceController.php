<?php

namespace App\Http\Controllers\API;

use App\Model\Enterprise;
use App\Model\EnterpriseLimit;
use App\Model\EnterpriseNote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnterpriseServiceController extends Controller
{
    public function openCnpj(Request $request)
    {
        $this->validate($request, ['cnpj' => 'required']);
        $enterprise = Enterprise::where('cnpj', \request('cnpj'))->first();
        return response()->json(['data' => $enterprise]);
    }

    public function storelimit(Request $request)
    {
        $this->validate($request, [
            'user' => 'required',
            'limit' => 'required'
        ]);

        $enterpriselimit = EnterpriseLimit::where('user', \request('user'))->first();
        if (is_null($enterpriselimit)) {
            $enterpriselimit = new EnterpriseLimit();
            $enterpriselimit->user = \request('user');
        }
        $enterpriselimit->amount = \request('limit');
        $enterpriselimit->save();

        return response()->json(['status' => 'OK']);
    }

    public function storenote(Request $request)
    {
        $this->validate($request, [
            'enterprise' => 'required',
            'amount' => 'required'
        ]);

        $note = EnterpriseNote::where('enterprise', \request('enterprise'))->first();
        $note->amount = \request('amount');
        $note->save();

        return response()->json(['status' => 'OK']);
    }
}