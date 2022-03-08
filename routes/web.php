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
Route::get(
    '/', function () {
        return view('welcome');
    }
);
Route::get('/calendar/events', ['as'=>'branch.calendar', 'uses'=> 'App\Http\Controllers\CalendarController@events']);
Route::get('/calendar', ['as'=>'calendar.index', 'uses'=> 'App\Http\Controllers\CalendarController@index']);
Route::get('/maps', ['as'=>'maps.api', 'uses'=>'App\Http\Controllers\AddressController@index']);
Route::resource('/activity', 'App\Http\Controllers\ActivitiesController');
Route::resource('/address', 'App\Http\Controllers\AddressController');
Route::get(
    '/dashboard', function () {
        return view('dashboard');
    }
)->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
