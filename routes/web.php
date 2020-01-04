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

    Route::get('/home/monitorworkshop/{workshop}','MonitorController@monitorworkshop')->name('monitorworkshop'); //edited
    Route::put('/home/monitorworkshop/{workshop}','MonitorController@joindoor')->name('joindoor'); // added  
    
    Route::get('/home/monitorworkshop/{workshop}/takecards','MonitorController@takecards')->name('takecards'); //added  
    Route::get('/home/monitorworkshop/{workshop}/takescores','MonitorController@takescores')->name('takescores'); //added
    Route::put('/home/monitorworkshop/{workshop}/takescores','MonitorController@shuffilecards')->name('shuffilecards'); //added 
    
    Route::get('/home/monitorworkshop/{workshop}/results','MonitorController@results')->name('results'); // added
    Route::post('/home/monitorworkshop/{workshop}/results','MonitorController@chooseprojects')->name('chooseprojects'); // added
    
});



// only Participant 
Route::middleware(['auth','participant'])->group(function() {
    Route::get('/home/joinworkshop','ParticipantController@joinworkshop')->name('joinworkshop');
    Route::post('/home/joinworkshop','ParticipantController@applytoworkshop')->name('applytoworkshop'); // added
    Route::get('/home/createcard/{workshop}','ParticipantController@createcard')->name('createcard'); // added
    Route::post('/home/createcard/{workshop}','ParticipantController@storecard')->name('storecard'); // added
    Route::get('/home/participantworkshop/{workshop}/card','ParticipantController@card')->name('card'); // added
    Route::put('/home/participantworkshop/{workshop}/votecard','ParticipantController@votecard')->name('votecard'); // added
    Route::get('/home/participantworkshop/{workshop}/chooseproject','ParticipantController@chooseproject')->name('chooseproject'); // added
});
