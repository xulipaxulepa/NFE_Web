<?php

namespace App\Http\Controllers\SYSTEM;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class EnterpriseLimitController extends Controller
{
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
        return View::make('enterpriselimit.index');
    }
}