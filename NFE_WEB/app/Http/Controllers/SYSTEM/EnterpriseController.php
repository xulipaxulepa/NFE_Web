<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Enterprise;
use App\Model\EnterpriseLimit;
use App\Model\EnterpriseNote;
use App\Model\UserEnterprise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class EnterpriseController extends Controller
{
    private $newWidthMINI = 500;
    private $newWidth = 1500;
    private $newHeightMINI = 500;
    private $newHeight = 1500;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verify_profile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->permission(['ROLE_ADMIN', 'ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        if (Auth::user()->permissionBoolean('ROLE_ADMIN')) {
            return View::make('enterprise.index');
        } else if (Auth::user()->permissionBoolean('ROLE_ENTERPRISE')) {
            if (!is_null(Enterprise::where('user', Auth::id())->first()) == null) {
                return Redirect::to('enterprise/create');
            }
            if (Session::has('enterprise')) {
                return Redirect::to('home');
            }
            return View::make('enterprise.enterprises');
        } else if (Auth::user()->permissionBoolean('ROLE_ENTERPRISE') || Auth::user()->permissionBoolean('ROLE_MANAGER')) {
            return View::make('enterprise.manager_enterprises');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->permission('ROLE_ENTERPRISE');
        if (Session::has('enterprise')) {
            return Redirect::to('home');
        }
        $taxs = [
            '1' => __("fields.enterprise_tax_regime_simple_national"),
            '2' => __("fields.enterprise_tax_regime_simple_national_exception_grouss"),
            '3' => __("fields.enterprise_tax_regime_normal_regime")
        ];
        return View::make('enterprise.create')->with('taxs', $taxs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->permission('ROLE_ENTERPRISE');
        if (Session::has('enterprise')) {
            return Redirect::to('home');
        }
        $limitEnterprise = EnterpriseLimit::where('user', Auth::id())->first();
        if ((is_null($limitEnterprise) ? __("fields.enterprise_limit_single") : $limitEnterprise->amount) > Enterprise::where('user', Auth::id())->count()) {
            $file = Input::file('photo');
            $filename = NULL;
            $filenameMINI = NULL;
            if (!is_null($file)) {
                $extension = $file->getClientOriginalExtension();
                $time = time();
                $filename = $time . "." . $file->getClientOriginalExtension();
                $file->move('upload/photo_enterprise/', $filename);
                $photo = NULL;
                if ($extension == "jpeg" || $extension == "jpg") {
                    $photo = imagecreatefromjpeg('upload/photo_enterprise/' . $filename);
                } else if ($extension == "png") {
                    $photo = imagecreatefrompng('upload/photo_enterprise/' . $filename);
                } else if ($extension == "gif") {
                    $photo = imagecreatefromgif('upload/photo_enterprise/' . $filename);
                }
                if (!is_null($photo)) {
                    list($width, $height) = getimagesize('upload/photo_enterprise/' . $filename);

                    $filenameMINI = $time . "_mini." . $extension;
                    $new_photo = imagecreatetruecolor($this->newWidthMINI, $this->newHeightMINI);
                    imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidthMINI, $this->newHeightMINI, $width, $height);
                    if ($extension == "jpeg" || $extension == "jpg") {
                        imagejpeg($new_photo, 'upload/photo_enterprise/' . $filenameMINI, 100);
                    } else if ($extension == "png") {
                        imagepng($new_photo, 'upload/photo_enterprise/' . $filenameMINI, 8);
                    } else if ($extension == "gif") {
                        imagegif($new_photo, 'upload/photo_enterprise/' . $filenameMINI, 100);
                    }

                    $new_photo = imagecreatetruecolor($this->newWidth, $this->newHeight);
                    imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                    if ($extension == "jpeg" || $extension == "jpg") {
                        imagejpeg($new_photo, 'upload/photo_enterprise/' . $filename, 100);
                    } else if ($extension == "png") {
                        imagepng($new_photo, 'upload/photo_enterprise/' . $filename, 8);
                    } else if ($extension == "gif") {
                        imagegif($new_photo, 'upload/photo_enterprise/' . $filename, 100);
                    }
                }
            }

            $fileCertified = Input::file('certified');
            $certified = NULL;
            if (!is_null($fileCertified)) {
                $extension = $fileCertified->getClientOriginalExtension();
                $certified = time() . "." . $extension;
                if ($extension != "pfx" || !$fileCertified->move('upload/certified_enterprise/', $certified)) {
                    Session::flash('danger', __("messages.fail_certified_send"));
                    $validator = Validator::make(Input::all(), []);
                    return Redirect::to('enterprise/create')->withErrors($validator)->withInput(Input::except('password'));
                }
            }

            $enterprise = new Enterprise();
            $enterprise->social_name = Input::get('social_name');
            $enterprise->fantasy_name = Input::get('fantasy_name');
            $enterprise->cnpj = Input::get('cnpj');
            $enterprise->legal_nature = Input::get('legal_nature');
            $enterprise->tax_regime = Input::get('tax_regime');
            $enterprise->state_registration = Input::get('state_registration');
            $enterprise->phone = Input::get('phone');
            $enterprise->cellphone = Input::get('cellphone');
            $enterprise->code_postal = Input::get('code_postal');
            $enterprise->place = Input::get('place');
            $enterprise->number = Input::get('number');
            $enterprise->complement = Input::get('complement');
            $enterprise->district = Input::get('district');
            $enterprise->code_city = Input::get('code_city');
            $enterprise->city = Input::get('city');
            $enterprise->code_state = Input::get('code_state');
            $enterprise->state = Input::get('state');
            $enterprise->certified = $certified;
            $enterprise->password_certified = Input::get('password_certified');
            $enterprise->photo = $filename;
            $enterprise->photo_mini = $filenameMINI;
            $enterprise->user = Auth::id();
            $enterprise->save();

            $enterpriseNote = new EnterpriseNote();
            $enterpriseNote->amount = __("fields.enterprise_note_single");
            $enterpriseNote->enterprise = $enterprise->id;
            $enterpriseNote->save();

            Session::put('enterprise', $enterprise);

            return Redirect::to('home');
        } else {
            Session::flash('danger', __("validation_jquery.limit_enterprise_exceded"));
            $validator = Validator::make(Input::all(), []);
            return Redirect::to('enterprise/create')->withErrors($validator)->withInput(Input::except('password'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Auth::user()->permission(['ROLE_ADMIN', 'ROLE_MANAGER']);
        $enterprise = Enterprise::find($id);
        return View::make('enterprise.show')->with('enterprise', $enterprise);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::user()->permission('ROLE_ENTERPRISE');

        $enterprise = Enterprise::find($id);

        if (!Session::has('enterprise')) {
            Session::put('enterprise', $enterprise);
        }

        $taxs = [
            '1' => __("fields.enterprise_tax_regime_simple_national"),
            '2' => __("fields.enterprise_tax_regime_simple_national_exception_grouss"),
            '3' => __("fields.enterprise_tax_regime_normal_regime")
        ];
        return View::make('enterprise.edit')->with('enterprise', $enterprise)->with('taxs', $taxs);
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
        Auth::user()->permission('ROLE_ENTERPRISE');
        $enterprise = Enterprise::find($id);

        if (!Session::has('enterprise')) {
            Session::put('enterprise', $enterprise);
        }

        $file = Input::file('photo');
        $filename = NULL;
        $filenameMINI = NULL;
        if (!is_null($file)) {
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $filename = $time . "." . $file->getClientOriginalExtension();
            $file->move('upload/photo_enterprise/', $filename);
            $photo = NULL;
            if ($extension == "jpeg" || $extension == "jpg") {
                $photo = imagecreatefromjpeg('upload/photo_enterprise/' . $filename);
            } else if ($extension == "png") {
                $photo = imagecreatefrompng('upload/photo_enterprise/' . $filename);
            } else if ($extension == "gif") {
                $photo = imagecreatefromgif('upload/photo_enterprise/' . $filename);
            }
            if (!is_null($photo)) {
                list($width, $height) = getimagesize('upload/photo_enterprise/' . $filename);

                $filenameMINI = $time . "_mini." . $extension;
                $new_photo = imagecreatetruecolor($this->newWidthMINI, $this->newHeightMINI);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidthMINI, $this->newHeightMINI, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_enterprise/' . $filenameMINI, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_enterprise/' . $filenameMINI, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_enterprise/' . $filenameMINI, 100);
                }

                $new_photo = imagecreatetruecolor($this->newWidth, $this->newHeight);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_enterprise/' . $filename, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_enterprise/' . $filename, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_enterprise/' . $filename, 100);
                }
            }
        }

        $fileCertified = Input::file('certified');
        $certified = NULL;
        if (!is_null($fileCertified)) {
            $extension = $fileCertified->getClientOriginalExtension();
            $certified = time() . "." . $extension;
            if ($extension != "pfx" || !$fileCertified->move('upload/certified_enterprise/', $certified)) {
                Session::flash('danger', __("messages.fail_certified_send"));
                $validator = Validator::make(Input::all(), []);
                return Redirect::to('enterprise/create')->withErrors($validator)->withInput(Input::except('password'));
            }
        }

        $enterprise->social_name = Input::get('social_name');
        $enterprise->fantasy_name = Input::get('fantasy_name');
        $enterprise->cnpj = Input::get('cnpj');
        $enterprise->legal_nature = Input::get('legal_nature');
        $enterprise->tax_regime = Input::get('tax_regime');
        $enterprise->state_registration = Input::get('state_registration');
        $enterprise->phone = Input::get('phone');
        $enterprise->cellphone = Input::get('cellphone');
        $enterprise->code_postal = Input::get('code_postal');
        $enterprise->place = Input::get('place');
        $enterprise->number = Input::get('number');
        $enterprise->complement = Input::get('complement');
        $enterprise->district = Input::get('district');
        $enterprise->code_city = Input::get('code_city');
        $enterprise->city = Input::get('city');
        $enterprise->code_state = Input::get('code_state');
        $enterprise->state = Input::get('state');
        if (!is_null($certified)) {
            $enterprise->certified = $certified;
        }
        $enterprise->password_certified = Input::get('password_certified');
        if (!is_null($filename)) {
            $enterprise->photo = $filename;
        }
        if (!is_null($filenameMINI)) {
            $enterprise->photo_mini = $filenameMINI;
        }
        $enterprise->save();
        Session::put('enterprise', $enterprise);
        Session::flash('success', __("messages.success"));
        return Redirect::to('enterprise/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->permission('ROLE_ADMIN');
        $enterprise = Enterprise::find($id);
        $enterprise->delete();
        return response()->json(['status' => 'OK']);
    }

    public function accessenterprise($id)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        if (!Session::has('enterprise')) {
            $enterprise = Enterprise::find($id);
            Session::put('enterprise', $enterprise);
        }
        return response()->json(['status' => 'OK']);
    }

    public function changeenterprise()
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        Session::forget('imported');
        Session::forget('enterprise');
        return response()->json(['status' => 'OK']);
    }

    public function destroyenterprise($id)
    {
        Auth::user()->permission(['ROLE_ENTERPRISE', 'ROLE_MANAGER']);
        if (!Session::has('enterprise')) {
            if(Auth::user()->permissionBoolean('ROLE_ENTERPRISE')) {
                $enterprise = Enterprise::find($id);
                $enterprise->delete();
                return response()->json(['status' => 'OK', 'null' => Enterprise::where('user', Auth::id())->first()]);
            } else {
                $enterprise = UserEnterprise::where('enterprise', $id)->where('user', Auth::id())->first();
                $enterprise->delete();
                return response()->json(['status' => 'OK']);
            }
        }
    }
}