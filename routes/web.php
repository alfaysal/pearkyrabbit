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
    Route::post('//employee/update','EmployeeController@UpdateEmploye