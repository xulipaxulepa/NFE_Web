<?php

namespace App\Http\Controllers\SERVER;

use App\Model\Cst;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CstWebController extends Controller
{
    public function all(Request $request)
    {
        $csts = Cst::where('main', TRUE)->where(function ($query) {
            $search = \request('search');
            if (!empty($search)) {
                $query->orWhere('code', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            }
        })->orderBy('code', 'ASC')->orderBy('description', 'ASC')->paginate(5);
        return ['count' => count($csts), 'html' => View::make('cst.list_csts')->with('csts', $csts)->render()];
    }
}
