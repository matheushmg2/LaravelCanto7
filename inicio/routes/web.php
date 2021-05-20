<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('admin/agenda', 'AgendaController')->names('agenda');

Route::resource('admin/discografia', 'DiscografiaController')->names('discografia');

Route::resource('admin/galerias', 'ImagensGaleriasController')->names('galerias');

Route::resource('admin/music/', 'PlayerMusicaController')->names('music');
Route::get('admin/music/search_page','PlayerMusicaController@search_page');
//Route::get('/search', 'PlayerMusicaController@search');
