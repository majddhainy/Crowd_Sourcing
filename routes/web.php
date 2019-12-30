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


// welcome page 
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// accessed by guests 
Route::get('/login' ,'AuthController@login')->name('getlogin');
Route::post('/login' ,'AuthController@postlogin')->name('postlogin');
Route::get('/register' ,'AuthController@register')->name('getregister');
Route::post('/register' ,'AuthController@store')->name('postregister');

// only auth for all roles
Route::middleware(['auth'])->group(function() {
Route::get('/home' , 'AuthController@index')->name('home');
Route::post('/logout' , 'AuthController@logout')->name('logout');
});


// only Admin
Route::middleware(['auth','admin'])->group(function() {
Route::PUT('/home/users/autoconfirm/','AdminController@autoconfirm')->name('autoconfirm');
Route::PUT('/home/users/{user}/','AdminController@updateuser')->name('updateuser');
});


// only Monitor 
Route::middleware(['auth','monitor'])->group(function() {
    Route::get('/home/createworkshop','MonitorController@createworkshop')->name('createworkshop');
    Route::post('/home/createworkshop','MonitorController@storeworkshop')->name('storeworkshop');
    Route::get('/home/workshop/{workshop}','MonitorController@workshopstatus')->name('workshopstatus');
    });



// only Participant 
Route::middleware(['auth','participant'])->group(function() {
    Route::get('/home/joinworkshop','ParticipantController@joinworkshop')->name('joinworkshop');
    });
