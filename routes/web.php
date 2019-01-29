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
    return view('welcome');
});

Route::get('/test_blank', function () {

    // $message = "Please verify your email to go to the dashboard";
    // Toastr::success($message, $title = "Email Verification", $options = []);

    return view('test_blank');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
