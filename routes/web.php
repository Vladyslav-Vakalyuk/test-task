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

//Route::get('/', 'ReportController@reportByDate');
Route::get('/report-percent', 'ReportController@reportStatisticOrPercent')->name('reportOfPercent');
Route::get('/user-report/{id}', 'UserController@eagerLoading')->name('eagerLoading');
Route::match(['get', 'post'], '/report', 'ReportController@reportByDate')->name('report');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

