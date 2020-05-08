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
Route::get('test', function () {
    return App\SMS::sendDynamic([
        [
            'name' => "Sharfuddin Shawon",
            'balance' => "12300",
            'phone' => "01612404200",
        ],
        [
            'name' => "Md Mainuddin",
            'balance' => "00321",
            'phone' => "01791033123",
        ],
    ], "Hello {name}, you have {balance}Tk due and your phone number is {phone}");
    // return App\SMS::send(['01612404200', '01791033123'], "Lorem ipsum dolor sit amet consectetur doloribus soluta nemo?");
    $url = "https://psms.dianahost.com/api/sms/v1/send";
    $url = "https://psms.dianahost.com/api/sms/v1/details";
    $ch = curl_init( $url );
    # Setup request to send json via POST.
    $payload = json_encode([
        "userid" => "shawon.techbros@gmail.com",
        "password" => "Desperado1",
        // "recipient" => "01612404200,01791033123",
        // "body" => "This is a test API call with curl.",
        "message_id" => "2758772"
    ]);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    // $payload = json_encode([
    //     "userid" => "shawon.techbros@gmail.com",
    //     "password" => "Desperado1",
    //     "recipient" => "01612404200,01791033123",
    //     "body" => "This is a test API call with curl.",
    //     "sender" => "8809612737373"
    // ]);
    // curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    # Return response instead of printing.
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    # Send request.
    $result = curl_exec($ch);
    curl_close($ch);
    # Print response.
    echo "<pre>$result</pre>";
});
Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );
Route::get ( '/callback/{service}', 'SocialAuthController@callback' );

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
    Route::get ( '/complete-registration', 'SocialAuthController@show' );
    Route::post ( '/complete-registration', 'SocialAuthController@complete' );
    Route::get ( '/profile/disconnect/{service}', 'SocialAuthController@disconnect' );

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

