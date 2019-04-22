<?php

namespace App\Http\Controllers\SERVER;

use App\Model\Ncm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class NcmWebController extends Controller
{
    public function all(Request $request)
    {
        $ncms = Ncm::where('main', TRUE)->where(function ($query) {
            $search = \request('search');
            if (!empty($search)) {
                $query->orWhere('code', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('ipi', 'LIKE', '%' . $search . '%');
            }
        })->orderBy('code', 'ASC')->orderBy('description', 'ASC')->orderBy('ipi', 'ASC')->paginate(5);
        return ['count' => count($ncms), 'html' => View::make('ncm.list_ncms')->with('ncms', $ncms)->render()];
    }
}
