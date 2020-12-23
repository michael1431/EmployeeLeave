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
    return view('welcome');
});

Route::get('employee','EmployeeController@index')->name('employee');
Route::get('/employee/get/data/{employee_id}','EmployeeController@getData')->name('employee.getData');
Route::post('/employee/leave/apply','EmployeeController@store')->name('employee.leave.apply');
Route::get('/leaveInfo/get/{leave_id}','EmployeeController@getLeaveInfo')->name('leave.getData');
