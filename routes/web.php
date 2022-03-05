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

Route::get(
    '/calendar', function () {
        return view('calendar');
    }
);

Route::get(
    'calendar/events', function (
        \Illuminate\Http\Request $request
    ) {
        

        $eventsList = App\Models\Activity::all();
        foreach ($eventsList as $event) {
            $events[] = [
                'id' => $event->id,
                'title' => $event->id. " Event",
                'start' => $event->activity_date->toDateString(),
            ];
        }

        return $events;
        
    }
);
Route::get('/maps', ['as'=>'maps.api', 'uses'=>'App\Http\Controllers\AddressController@index']);

Route::get(
    '/dashboard', function () {
        return view('dashboard');
    }
)->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
