<?php

use Illuminate\Http\Request;

Route::post('user_all', 'SERVER\UserWebController@all');

Route::post('enterprise_all_single_enterprise', 'SERVER\EnterpriseWebController@allEnterprise');
Route::post('enterprise_all', 'SERVER\EnterpriseWebController@all');
Route::post('enterprise_all_limits', 'SERVER\EnterpriseWebController@allLimits');
Route::post('enterprise_all_single_manager', 'SERVER\EnterpriseWebController@allManager');

Route::post('user_enterprise_all', 'SERVER\UserEnterpriseWebController@all');

Route::post('cfop_all', 'SERVER\CfopWebController@all');

Route::post('ncm_all', 'SERVER\NcmWebController@all');

Route::post('cst_all', 'SERVER\CstWebController@all');

Route::post('product_all', 'SERVER\ProductWebController@all');

Route::post('note_all', 'SERVER\NoteWebController@all');
