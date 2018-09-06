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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register/teacher', 'TeacherRegisterController@start')->name('teacher-register.start');
Route::post('/register/teacher', 'TeacherRegisterController@startPost')->name('teacher-register.startPost');
Route::get('/register/teacher/classes', 'TeacherRegisterController@classes')->name('teacher-register.classes');
Route::get('/register/teacher/classes/add', 'TeacherRegisterController@classesAdd')->name('teacher-register.classes.add');
Route::post('/register/teacher/classes/add', 'TeacherRegisterController@classesAddPost')->name('teacher-register.classes.add.post');
