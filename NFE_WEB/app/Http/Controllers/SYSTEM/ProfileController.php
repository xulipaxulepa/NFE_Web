<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!is_null(Profile::where('user', Auth::id())->first())) {
            return Redirect::to('home');
        }
        return View::make('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!is_null(Profile::where('user', Auth::id())->first())) {
            return Redirect::to('home');
        }
        $file = Input::file('photo');
        $filename = NULL;
        $filenameMINI = NULL;
        if (!is_null($file)) {
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $filename = $time . "." . $file->getClientOriginalExtension();
            $file->move('upload/photo_profile/', $filename);
            $photo = NULL;
            if ($extension == "jpeg" || $extension == "jpg") {
                $photo = imagecreatefromjpeg('upload/photo_profile/' . $filename);
            } else if ($extension == "png") {
                $photo = imagecreatefrompng('upload/photo_profile/' . $filename);
            } else if ($extension == "gif") {
                $photo = imagecreatefromgif('upload/photo_profile/' . $filename);
            }
            if (!is_null($photo)) {
                list($width, $height) = getimagesize('upload/photo_profile/' . $filename);

                $filenameMINI = $time . "_mini." . $extension;
                $new_photo = imagecreatetruecolor($this->newWidthMINI, $this->newHeightMINI);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidthMINI, $this->newHeightMINI, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_profile/' . $filenameMINI, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_profile/' . $filenameMINI, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_profile/' . $filenameMINI, 100);
                }

                $new_photo = imagecreatetruecolor($this->newWidth, $this->newHeight);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_profile/' . $filename, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_profile/' . $filename, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_profile/' . $filename, 100);
                }
            }
        }
        $profile = new Profile();
        $profile->birth = Input::get('birth');
        $profile->cpf = Input::get('cpf');
        $profile->rg = Input::get('rg');
        $profile->phone = Input::get('phone');
        $profile->cellphone = Input::get('cellphone');
        $profile->code_postal = Input::get('code_postal');
        $profile->place = Input::get('place');
        $profile->number = Input::get('number');
        $profile->complement = Input::get('complement');
        $profile->district = Input::get('district');
        $profile->city = Input::get('city');
        $profile->state = Input::get('state');
        $profile->photo = $filename;
        $profile->photo_mini = $filenameMINI;
        $profile->user = Auth::id();
        $profile->save();
        return Redirect::to('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Auth::user()->permission('ROLE_ADMIN');
        $profile = Profile::find($id);
        return View::make('profile.show')->with('profile', $profile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::find($id);
        if (!is_null($profile)) {
            Session::put('profile', $profile);
        }
        return View::make('profile.edit')->with('profile', $profile);
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
        $profile = Profile::find($id);
        if (!is_null($profile)) {
            Session::put('profile', $profile);
        }

        $file = Input::file('photo');
        $filename = NULL;
        $filenameMINI = NULL;
        if (!is_null($file)) {
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $filename = $time . "." . $file->getClientOriginalExtension();
            $file->move('upload/photo_profile/', $filename);
            $photo = NULL;
            if ($extension == "jpeg" || $extension == "jpg") {
                $photo = imagecreatefromjpeg('upload/photo_profile/' . $filename);
            } else if ($extension == "png") {
                $photo = imagecreatefrompng('upload/photo_profile/' . $filename);
            } else if ($extension == "gif") {
                $photo = imagecreatefromgif('upload/photo_profile/' . $filename);
            }
            if (!is_null($photo)) {
                list($width, $height) = getimagesize('upload/photo_profile/' . $filename);

                $filenameMINI = $time . "_mini." . $extension;
                $new_photo = imagecreatetruecolor($this->newWidthMINI, $this->newHeightMINI);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidthMINI, $this->newHeightMINI, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_profile/' . $filenameMINI, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_profile/' . $filenameMINI, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_profile/' . $filenameMINI, 100);
                }

                $new_photo = imagecreatetruecolor($this->newWidth, $this->newHeight);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_profile/' . $filename, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_profile/' . $filename, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_profile/' . $filename, 100);
                }
            }
        }

        $profile = Profile::find($id);
        $profile->birth = Input::get('birth');
        $profile->cpf = Input::get('cpf');
        $profile->rg = Input::get('rg');
        $profile->phone = Input::get('phone');
        $profile->cellphone = Input::get('cellphone');
        $profile->code_postal = Input::get('code_postal');
        $profile->place = Input::get('place');
        $profile->number = Input::get('number');
        $profile->complement = Input::get('complement');
        $profile->district = Input::get('district');
        $profile->city = Input::get('city');
        $profile->state = Input::get('state');
        if (!is_null($filename)) {
            $profile->photo = $filename;
        }
        if (!is_null($filenameMINI)) {
            $profile->photo_mini = $filenameMINI;
        }
        $profile->save();

        Session::flash('success', __("messages.success"));
        return Redirect::to('profile/' . $id . '/edit');
    }
}