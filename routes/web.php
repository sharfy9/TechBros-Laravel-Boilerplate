<?php

use Illuminate\Support\Facades\Route;

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
    if(Auth::check())
        return redirect('/dashboard');
    else
        return view('welcome');
});
Auth::routes();

Route::post('/2fa', function () {
	return redirect(URL()->previous());
})->name('2fa')->middleware('2fa');
Route::get('/2fa', function () {
	return redirect("/dashboard");
});

Route::group(['middleware' => ['auth', '2fa']], function () {

    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('2fa/disable', "tfaController@disable");
	Route::get('2fa/disable/{id}', "tfaController@adminDisable");
	Route::get('2fa/setup', "tfaController@setup");
	Route::post('2fa/setup', "tfaController@save");
	Route::get('activity', 'ActivityController@index');
	Route::get('activity/{mode}', 'ActivityController@index');
	Route::get('user/loginas/{id}', 'UserController@loginAs');
	Route::post('user/loginas', 'UserController@loginAs');

    Route::post('user/active', 'UserController@active');
	Route::resource('user', 'UserController');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

