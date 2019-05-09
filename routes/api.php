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

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
Route::get('/academic_field', 'Admin\Api\AjaxController@academic_field')->name('ajax.academic_field');
Route::get('/account_field', 'Admin\Api\AjaxController@account_field')->name('ajax.account_field');
Route::get('/document_field', 'Admin\Api\AjaxController@document_field')->name('ajax.document_field');