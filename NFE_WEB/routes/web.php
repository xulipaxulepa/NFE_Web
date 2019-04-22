<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(\App\User::count() == 0){
        return \Illuminate\Support\Facades\Redirect::to('register');
    } else {
        if(\Illuminate\Support\Facades\Auth::check()) {
            return \Illuminate\Support\Facades\Redirect::to('home');
        } else {
            return \Illuminate\Support\Facades\Redirect::to('login');
        }
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('profile', 'SYSTEM\ProfileController');

Route::resource('user', 'SYSTEM\UserController');
Route::get('user/status/{id}', 'SYSTEM\UserController@status');

Route::resource('soon', 'SYSTEM\SoonController');

Route::resource('enterprise', 'SYSTEM\EnterpriseController');
Route::get('enterprise/process/change', 'SYSTEM\EnterpriseController@changeenterprise');
Route::get('enterprise/list/{id}', 'SYSTEM\EnterpriseController@accessenterprise');
Route::delete('enterprise/list/destroy/{id}', 'SYSTEM\EnterpriseController@destroyenterprise');

Route::resource('enterpriselimit', 'SYSTEM\EnterpriseLimitController');

Route::resource('userenterprise', 'SYSTEM\UserEnterpriseController');

Route::resource('cfop', 'SYSTEM\CfopController');

Route::resource('ncm', 'SYSTEM\NcmController');

Route::resource('cst', 'SYSTEM\CstController');

Route::get('process', 'HomeController@process');

Route::resource('product', 'SYSTEM\ProductController');

Route::resource('note', 'SYSTEM\NoteController');
Route::get('note/{type}/{id}', 'SYSTEM\NoteController@download');
