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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/', 'HomeController@index')->name('landing');

    //Alterar Senha
    Route::resource('password_change', 'Auth\ChangePasswordController');

    //Publicações
    Route::resource('posts', 'PostController');
    Route::get('posts/{subject_id?}/list', 'PostController@index')->name('posts.indexList');

    //Comentários
    Route::resource('comments', 'CommentController');
    Route::post('comments/markNotifAsRead', 'CommentController@markNotifAsRead');

    //Anos
    Route::resource('years', 'YearController')->except(['destroy']);;
    Route::get('years/destroy/{id}', 'YearController@destroy')->name('years.destroy');

    //Matérias
    Route::resource('classes', 'ClassController')->except(['destroy']);
    Route::get('classes/destroy/{id}', 'ClassController@destroy')->name('classes.destroy');
    Route::get('years/{id}/classes', 'ClassController@getYearClasses')->name('years.classes');

    //Assuntos
    Route::resource('subjects', 'SubjectController')->except(['destroy', 'index', 'show']);
    Route::get('subjects/{class_id?}', 'SubjectController@index')->name('subjects.index');
    Route::get('subjects/destroy/{id}', 'SubjectController@destroy')->name('subjects.destroy');
    Route::get('classes/{id}/subjects', 'SubjectController@getClasseSubjects')->name('classes.subjects');

    Route::prefix('upload/image')->group(function () {
        Route::post('year', 'YearController@uploadImage')->name('years.uploadImage');
        Route::post('class', 'ClassController@uploadImage')->name('classes.uploadImage');
        Route::post('post', 'PostController@uploadImage')->name('posts.uploadImage');
        Route::post('comment', 'CommentController@uploadImage')->name('comments.uploadImage');
    });

    //Segurança
    Route::prefix('security')->group(function () {

        //Usuários
        Route::resource('users', 'UserController')->except(['destroy']);;
        Route::get('users/destroy/{id}', 'UserController@destroy')->name('users.destroy');

        //Permissões
        Route::resource('roles', 'RoleController')->except(['destroy']);
        Route::get('roles/{id}/delete', 'RoleController@destroy')->name('roles.destroy');
    });
});
