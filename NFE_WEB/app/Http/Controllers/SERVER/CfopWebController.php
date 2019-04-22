<?php

namespace App\Http\Controllers\SERVER;

use App\Model\Cfop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CfopWebController extends Controller
{
    public function all(Request $request)
    {
        $cfops = Cfop::where('main', TRUE)->where(function ($query) {
            $search = \request('search');
            if (!empty($search)) {
                $query->orWhere('code', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            }
        })->orderBy('code', 'ASC')->orderBy('description', 'ASC')->paginate(5);
        return ['count' => count($cfops), 'html' => View::make('cfop.list_cfops')->with('cfops', $cfops)->render()];
    }
}
