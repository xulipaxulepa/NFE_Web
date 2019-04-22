<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user_open_email', 'API\UserServiceController@openEmail');
Route::post('user_open_email_password', 'API\UserServiceController@openEmailPassword');

Route::post('profile_open_cpf', 'API\ProfileServiceController@openCpf');

Route::post('enterprise_open_cnpj', 'API\EnterpriseServiceController@openCnpj');
Route::post('enterprise_store_limit', 'API\EnterpriseServiceController@storelimit');
Route::post('enterprise_store_note', 'API\EnterpriseServiceController@storenote');

Route::post('user_enterprise_open_email', 'API\UserEnterpriseServiceController@openEmail');

Route::post('cfop_open_code', 'API\CfopServiceController@openCode');
Route::post('cfop_all_select', 'API\CfopServiceController@allSelect');
Route::post('cfop_store', 'API\CfopServiceController@store');
Route::post('cfop_show', 'API\CfopServiceController@show');
Route::post('cfop_update', 'API\CfopServiceController@update');
Route::delete('cfop_destroy', 'API\CfopServiceController@destroy');

Route::post('ncm_open_code', 'API\NcmServiceController@openCode');
Route::post('ncm_all_select', 'API\NcmServiceController@allSelect');
Route::post('ncm_show', 'API\NcmServiceController@show');
Route::post('ncm_store', 'API\NcmServiceController@store');
Route::post('ncm_update', 'API\NcmServiceController@update');
Route::delete('ncm_destroy', 'API\NcmServiceController@destroy');

Route::post('cst_open_code', 'API\CstServiceController@openCode');
Route::post('cst_all_select', 'API\CstServiceController@allSelect');
Route::post('cst_store', 'API\CstServiceController@store');
Route::post('cst_show', 'API\CstServiceController@show');
Route::post('cst_update', 'API\CstServiceController@update');
Route::delete('cst_destroy', 'API\CstServiceController@destroy');

Route::post('product_all_select', 'API\ProductServiceController@allSelect');
Route::post('product_store', 'API\ProductServiceController@store');
Route::post('product_show', 'API\ProductServiceController@show');
Route::post('product_update', 'API\ProductServiceController@update');
Route::delete('product_destroy', 'API\ProductServiceController@destroy');

Route::post('process/ajax', 'HomeController@processAjax');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
