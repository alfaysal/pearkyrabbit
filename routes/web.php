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
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix' => 'Employee', 'middleware' => 'auth'], function () {

    Route::get('/home','EmployeeController@index')->name('index');
    Route::post('/employee/store','EmployeeController@EmployeeStore');
    Route::get('/table/data','EmployeeController@DatatableData')->name('datatables_data');
    Route::post('/edit/data','EmployeeController@EditData');
    Route::post('/employee/update','EmployeeController@UpdateEmployee');
    Route::post('/delete/data','EmployeeController@DeleteEmployee');


});

Route::group(['prefix' => 'Search_Insert', 'middleware' => 'auth'], function () {

    Route::get('/page','SearchInsertController@index')->name('serach_insert_index');
    Route::post('/employee/search','SearchInsertController@SearchEmployee');
    Route::post('/individualAppend/data','SearchInsertController@getEmployee');



});

// Route::get('/home', 'HomeController@index')->name('home');
