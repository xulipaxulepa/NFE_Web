<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Cfop;
use App\Model\Ncm;
use App\Model\NcmEnterprise;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    private $newWidthMINI = 500;
    private $newWidth = 1500;
    private $newHeightMINI = 500;
    private $newHeight = 1500;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verify_profile');
        $this->middleware('verify_enterprise');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        return View::make('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        return View::make('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $valueField = Input::get('value');
        $value = "";
        for ($v = 0; $v < strlen($valueField); $v++) {
            if (!is_numeric($valueField[$v]) && ($valueField[$v] == "," || $valueField[$v] == ".")) {
                $value .= ".";
            } else if (is_numeric($valueField[$v])) {
                $value .= $valueField[$v];
            }
        }

        $priceField = Input::get('price');
        $price = "";
        for ($v = 0; $v < strlen($priceField); $v++) {
            if (!is_numeric($priceField[$v]) && ($priceField[$v] == "," || $priceField[$v] == ".")) {
                $price .= ".";
            } else if (is_numeric($priceField[$v])) {
                $price .= $priceField[$v];
            }
        }

        $aliquotaField = Input::get('aliquota');
        $aliquota = "";
        for ($v = 0; $v < strlen($aliquotaField); $v++) {
            if (!is_numeric($aliquotaField[$v]) && ($aliquotaField[$v] == "," || $aliquotaField[$v] == ".")) {
                $aliquota .= ".";
            } else if (is_numeric($aliquotaField[$v])) {
                $aliquota .= $aliquotaField[$v];
            }
        }

        $ipiField = Input::get('ipi');
        $ipi = "";
        for ($v = 0; $v < strlen($ipiField); $v++) {
            if (!is_numeric($ipiField[$v]) && ($ipiField[$v] == "," || $ipiField[$v] == ".")) {
                $ipi .= ".";
            } else if (is_numeric($ipiField[$v])) {
                $ipi .= $ipiField[$v];
            }
        }

        $file = Input::file('photo');
        $filename = NULL;
        $filenameMINI = NULL;
        if (!is_null($file)) {
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $filename = $time . "." . $file->getClientOriginalExtension();
            $file->move('upload/photo_product/', $filename);
            $photo = NULL;
            if ($extension == "jpeg" || $extension == "jpg") {
                $photo = imagecreatefromjpeg('upload/photo_product/' . $filename);
            } else if ($extension == "png") {
                $photo = imagecreatefrompng('upload/photo_product/' . $filename);
            } else if ($extension == "gif") {
                $photo = imagecreatefromgif('upload/photo_product/' . $filename);
            }
            if (!is_null($photo)) {
                list($width, $height) = getimagesize('upload/photo_product/' . $filename);

                $filenameMINI = $time . "_mini." . $extension;
                $new_photo = imagecreatetruecolor($this->newWidthMINI, $this->newHeightMINI);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidthMINI, $this->newHeightMINI, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_product/' . $filenameMINI, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_product/' . $filenameMINI, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_product/' . $filenameMINI, 100);
                }

                $new_photo = imagecreatetruecolor($this->newWidth, $this->newHeight);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_product/' . $filename, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_product/' . $filename, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_product/' . $filename, 100);
                }
            }
        }

        $product = new Product();
        $product->name = Input::get('name');
        $product->ncm = Input::get('ncm');
        $product->cfop = Input::get('cfop');
        $product->unit = Input::get('unit');
        $product->value = $value;
        $product->price = $price;
        $product->aliquota = $aliquota;
        $product->ipi = $ipi;
        $product->photo = $filename;
        $product->photo_mini = $filenameMINI;
        $product->enterprise = Session::get('enterprise')->id;
        $product->save();

        Session::flash('success', __("messages.success"));
        return Redirect::to('product/create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $product = Product::find($id);

        $ncm = Ncm::find($product->ncm);
        $ncmEnterprise = NcmEnterprise::where('ncm', $ncm->id)->where('enterprise', $product->enterprise)->first();
        if(is_null($ncmEnterprise)) {
            $product->ncm_str = $ncm->code . (!is_null($ncm->description) ? " - " . $ncm->description : "");
        } else {
            $product->ncm_str = $ncmEnterprise->code . (!is_null($ncmEnterprise->description) ? " - " . $ncmEnterprise->description : "");
        }

        $cfop = Cfop::find($product->cfop);
        $product->cfop_str = $cfop->code . (!is_null($cfop->description) ? " - " . $cfop->description : "");

        return View::make('product.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $valueField = Input::get('value');
        $value = "";
        for ($v = 0; $v < strlen($valueField); $v++) {
            if (!is_numeric($valueField[$v]) && ($valueField[$v] == "," || $valueField[$v] == ".")) {
                $value .= ".";
            } else if (is_numeric($valueField[$v])) {
                $value .= $valueField[$v];
            }
        }

        $priceField = Input::get('price');
        $price = "";
        for ($v = 0; $v < strlen($priceField); $v++) {
            if (!is_numeric($priceField[$v]) && ($priceField[$v] == "," || $priceField[$v] == ".")) {
                $price .= ".";
            } else if (is_numeric($priceField[$v])) {
                $price .= $priceField[$v];
            }
        }

        $aliquotaField = Input::get('aliquota');
        $aliquota = "";
        for ($v = 0; $v < strlen($aliquotaField); $v++) {
            if (!is_numeric($aliquotaField[$v]) && ($aliquotaField[$v] == "," || $aliquotaField[$v] == ".")) {
                $aliquota .= ".";
            } else if (is_numeric($aliquotaField[$v])) {
                $aliquota .= $aliquotaField[$v];
            }
        }

        $ipiField = Input::get('ipi');
        $ipi = "";
        for ($v = 0; $v < strlen($ipiField); $v++) {
            if (!is_numeric($ipiField[$v]) && ($ipiField[$v] == "," || $ipiField[$v] == ".")) {
                $ipi .= ".";
            } else if (is_numeric($ipiField[$v])) {
                $ipi .= $ipiField[$v];
            }
        }

        $file = Input::file('photo');
        $filename = NULL;
        $filenameMINI = NULL;
        if (!is_null($file)) {
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $filename = $time . "." . $file->getClientOriginalExtension();
            $file->move('upload/photo_product/', $filename);
            $photo = NULL;
            if ($extension == "jpeg" || $extension == "jpg") {
                $photo = imagecreatefromjpeg('upload/photo_product/' . $filename);
            } else if ($extension == "png") {
                $photo = imagecreatefrompng('upload/photo_product/' . $filename);
            } else if ($extension == "gif") {
                $photo = imagecreatefromgif('upload/photo_product/' . $filename);
            }
            if (!is_null($photo)) {
                list($width, $height) = getimagesize('upload/photo_product/' . $filename);

                $filenameMINI = $time . "_mini." . $extension;
                $new_photo = imagecreatetruecolor($this->newWidthMINI, $this->newHeightMINI);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidthMINI, $this->newHeightMINI, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_product/' . $filenameMINI, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_product/' . $filenameMINI, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_product/' . $filenameMINI, 100);
                }

                $new_photo = imagecreatetruecolor($this->newWidth, $this->newHeight);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_product/' . $filename, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_product/' . $filename, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_product/' . $filename, 100);
                }
            }
        }

        $product = Product::find($id);
        $product->name = Input::get('name');
        $product->ncm = Input::get('ncm');
        $product->cfop = Input::get('cfop');
        $product->unit = Input::get('unit');
        $product->value = $value;
        $product->price = $price;
        $product->aliquota = $aliquota;
        $product->ipi = $ipi;
        if (!is_null($filename)) {
            $product->photo = $filename;
        }
        if (!is_null($filenameMINI)) {
            $product->photo_mini = $filenameMINI;
        }
        $product->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('product/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        $product = Product::find($id);
        $product->delete();
        return response()->json(['status' => 'OK']);
    }
}