<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'Api\UserController@login');

//logged in
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('parameter/values', 'Api\ParameterValueController@index');

    Route::get('schedule', 'Api\ScheduleController@index');
    Route::post('schedule/store', 'Api\ScheduleController@store');
    Route::delete('schedule/{id}', 'Api\ScheduleController@delete');

    Route::get('users/show', 'Api\UserController@show');
    Route::post('users/update', 'Api\UserController@update');

    Route::get('subjects', 'Api\SubjectsController@index');
    Route::post('subjects/store', 'Api\SubjectsController@store');
    Route::put('subjects/update', 'Api\SubjectsController@update');
    Route::delete('subjects/{id}', 'Api\SubjectsController@delete');

    Route::get('teach', 'Api\TeachController@teach');
    Route::get('teach/subjects', 'Api\TeachController@subject');
    Route::post('teach/assign', 'Api\TeachController@assign');
    Route::post('teach/subjects/delete', 'Api\TeachController@deleteAssign');

    Route::get('tutorship', 'Api\TutorshipController@index');
    Route::get('tutorship/show', 'Api\TutorshipController@show');
    Route::post('tutorship/store', 'Api\TutorshipController@store');

});
