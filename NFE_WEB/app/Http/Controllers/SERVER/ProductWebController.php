<?php

namespace App\Http\Controllers\SERVER;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ProductWebController extends Controller
{
    public function all(Request $request)
    {
        $this->validate($request, ['enterprise' => 'required']);
        $products = Product::select('products.*')
            ->join('ncms', 'ncms.id', '=', 'products.ncm')
            ->where('products.enterprise', \request('enterprise'))
            ->where(function ($query) {
                $search = \request('search');
                if (!empty($search)) {
                    $query->orWhere('products.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('ncms.code', 'LIKE', '%' . $search . '%')
                        ->orWhere('ncms.description', 'LIKE', '%' . $search . '%')
                        ->orWhere('products.unit', 'LIKE', '%' . $search . '%')
                        ->orWhere('products.price', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('products.name', 'ASC')->paginate(5);
        return ['count' => count($products), 'html' => View::make('product.list_products')->with('products', $products)->render()];
    }
}
