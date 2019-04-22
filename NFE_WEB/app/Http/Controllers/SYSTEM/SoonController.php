<?php

namespace App\Http\Controllers\SYSTEM;

use App\Model\Soon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class SoonController extends Controller
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
        Auth::user()->permission('ROLE_ADMIN');
        $soon = Soon::first();
        if (is_null($soon)) {
            return View::make('soon.create');
        } else {
            return View::make('soon.edit')->with('soon', $soon);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->permission('ROLE_ADMIN');
        $soon = Soon::first();
        if (!is_null($soon)) {
            return Redirect::to('soon');
        }

        $file = Input::file('photo');
        $filename = NULL;
        $filenameMINI = NULL;
        if (!is_null($file)) {
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $filename = $time . "." . $file->getClientOriginalExtension();
            $file->move('upload/photo_soon/', $filename);
            $photo = NULL;
            if ($extension == "jpeg" || $extension == "jpg") {
                $photo = imagecreatefromjpeg('upload/photo_soon/' . $filename);
            } else if ($extension == "png") {
                $photo = imagecreatefrompng('upload/photo_soon/' . $filename);
            } else if ($extension == "gif") {
                $photo = imagecreatefromgif('upload/photo_soon/' . $filename);
            }
            if (!is_null($photo)) {
                list($width, $height) = getimagesize('upload/photo_soon/' . $filename);

                $filenameMINI = $time . "_mini." . $extension;
                $new_photo = imagecreatetruecolor($this->newWidthMINI, $this->newHeightMINI);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidthMINI, $this->newHeightMINI, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_soon/' . $filenameMINI, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_soon/' . $filenameMINI, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_soon/' . $filenameMINI, 100);
                }

                $new_photo = imagecreatetruecolor($this->newWidth, $this->newHeight);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_soon/' . $filename, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_soon/' . $filename, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_soon/' . $filename, 100);
                }
            }
        }

        $soon = new Soon();
        $soon->photo = $filename;
        $soon->photo_mini = $filenameMINI;
        $soon->save();
        Session::flash('success', __("messages.success"));
        return Redirect::to('soon');
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
        Auth::user()->permission('ROLE_ADMIN');
        $soon = Soon::find($id);
        if (is_null($soon)) {
            return Redirect::to('soon');
        }

        $file = Input::file('photo');
        $filename = NULL;
        $filenameMINI = NULL;
        if (!is_null($file)) {
            $extension = $file->getClientOriginalExtension();
            $time = time();
            $filename = $time . "." . $file->getClientOriginalExtension();
            $file->move('upload/photo_soon/', $filename);
            $photo = NULL;
            if ($extension == "jpeg" || $extension == "jpg") {
                $photo = imagecreatefromjpeg('upload/photo_soon/' . $filename);
            } else if ($extension == "png") {
                $photo = imagecreatefrompng('upload/photo_soon/' . $filename);
            } else if ($extension == "gif") {
                $photo = imagecreatefromgif('upload/photo_soon/' . $filename);
            }
            if (!is_null($photo)) {
                list($width, $height) = getimagesize('upload/photo_soon/' . $filename);

                $filenameMINI = $time . "_mini." . $extension;
                $new_photo = imagecreatetruecolor($this->newWidthMINI, $this->newHeightMINI);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidthMINI, $this->newHeightMINI, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_soon/' . $filenameMINI, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_soon/' . $filenameMINI, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_soon/' . $filenameMINI, 100);
                }

                $new_photo = imagecreatetruecolor($this->newWidth, $this->newHeight);
                imagecopyresampled($new_photo, $photo, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                if ($extension == "jpeg" || $extension == "jpg") {
                    imagejpeg($new_photo, 'upload/photo_soon/' . $filename, 100);
                } else if ($extension == "png") {
                    imagepng($new_photo, 'upload/photo_soon/' . $filename, 8);
                } else if ($extension == "gif") {
                    imagegif($new_photo, 'upload/photo_soon/' . $filename, 100);
                }
            }
        }

        $soon = Soon::find($id);
        $soon->photo = $filename;
        $soon->photo_mini = $filenameMINI;
        $soon->save();

        Session::flash('success', __("messages.success"));
        return Redirect::to('soon');
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
        $soon = Soon::find($id);
        $soon->delete();
        return response()->json(['status' => 'OK']);
    }
}