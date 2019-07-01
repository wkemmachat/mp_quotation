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

// Role
Route::get('user/role', 'RoleController@index')->name('role');
Route::post('user/role', 'RoleController@store')->name('role.store');
Route::match(['put', 'patch'], 'user/role/update/{id}','RoleController@update')->name('role.update');
Route::delete('user/role/{id}', 'RoleController@destroy')->name('role.destroy');

// Role_User
Route::get('user/manageRole_user', 'RoleController@role_user_index')->name('role_user');
Route::post('user/manageRole_user', 'RoleController@role_user_store')->name('role_user.store');
Route::get('user/manageRole_user/edit/{id}','RoleController@role_user_edit')->name('role_user.edit');
Route::match(['put', 'patch'], 'user/manageRole_user/update/{id}','RoleController@role_user_update')->name('role_user.update');

// User
Route::post('/user/manageUser', 'UserController@store')->name('user.store');
Route::get('/user/manageUser', 'UserController@index')->name('user');
Route::get('/user/manageUser/edit/{id}','UserController@edit')->name('user.edit');
Route::match(['put', 'patch'], '/user/manageUser/update/{id}','UserController@update')->name('user.update');
Route::delete('/user/manageUser/{id}', 'UserController@destroy')->name('user.destroy');
Route::get('/user/manageUser/changeStatus/{id}','UserController@changeStatus')->name('user.changeStatus');

// Product
Route::post('/product/manageProduct', 'ProductController@store')->name('product.store');
Route::get('/product/manageProduct', 'ProductController@index')->name('product');
Route::get('/product/manageProduct/edit/{id}','ProductController@edit')->name('product.edit');
Route::match(['put', 'patch'], '/product/manageProduct/update/{id}','ProductController@update')->name('product.update');



// KPI
Route::get('/kpi_output/{id}','KpiOutputController@index')->name('kpi_output');
Route::post('/kpi_output/{id}','KpiOutputController@store')->name('kpi_output.store');
Route::delete('/kpi_output/{id}','KpiOutputController@destroy')->name('kpi_output.delete');

// Export
Route::post('/exportKPI', 'KpiOutputController@exportKPI')->name('kpi_output.exportKPI');
Route::post('/exportProduct', 'ProductController@exportProduct')->name('product.exportProduct');

// KemLogin
Route::post('/login_kem', 'KemLoginController@login')->name('login_kem');


/*
// qc
Route::get('/qc', 'QcController@index')->name('qc');
Route::post('/qc', 'QcController@store')->name('qc.store');

// production
Route::get('/production', 'ProductionController@index')->name('production');
Route::post('/production', 'ProductionController@store')->name('production.store');

// store
Route::get('/store', 'StoreController@index')->name('store');
Route::post('/store', 'StoreController@store')->name('store.store');

// planning
Route::get('/planning', 'PlanningController@index')->name('planning');
Route::post('/planning', 'PlanningController@store')->name('planning.store');

// logistic
Route::get('/logistic', 'LogisticController@index')->name('logistic');
Route::post('/logistic', 'LogisticController@store')->name('logistic.store');
*/
