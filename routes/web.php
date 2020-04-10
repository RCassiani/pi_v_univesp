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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    //Segurança
    Route::prefix('security')->group(function (){

        //Usuários
        Route::resource('users', 'UserController')->except(['destroy']);;
        Route::get('users/destroy/{id}', 'UserController@destroy')->name('users.destroy');

        //Permissões
        Route::resource('roles', 'RoleController')->except(['destroy']);
        Route::get('roles/{id}/delete', 'RoleController@destroy')->name('roles.destroy');

    });
});
