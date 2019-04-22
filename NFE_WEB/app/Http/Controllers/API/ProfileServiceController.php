<?php

namespace App\Http\Controllers\API;

use App\Model\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileServiceController extends Controller
{
    public function openCpf(Request $request)
    {
        $this->validate($request, ['cpf' => 'required']);
        $profile = Profile::where('cpf', \request('cpf'))->first();
        return response()->json(['data' => $profile]);
    }
}