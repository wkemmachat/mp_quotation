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

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Route::resource('category','CategoryController');

Route::get('/home', 'HomeController@index')->name('home');

// Category
Route::get('/category', 'CategoryController@index')->name('category');
Route::post('/category', 'CategoryController@store')->name('category.store');
Route::get('/category/edit/{id}','CategoryController@edit');
Route::match(['put', 'patch'], '/category/update/{id}','CategoryController@update')->name('category.update');
Route::delete('/category/{id}', 'CategoryController@destroy')->name('category.destroy');

// User
Route::get('/addUser', 'UserController@addUser')->name('addUser');
Route::get('/ListUser', 'UserController@index')->name('listUser');
