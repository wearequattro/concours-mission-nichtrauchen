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

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login.post');
Route::get('/login/recover', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('login.password.recover');
Route::post('/login/recover', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('login.password.recover.post');
Route::get('/login/recover/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('login.password.reset');
Route::post('/login/recover/reset', 'Auth\ResetPasswordController@reset')->name('login.password.reset.post');
Route::get('/login/redirect', 'Auth\LoginController@loginRedirect')->name('login.redirect');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/teacher/register', 'TeacherRegisterController@start')->name('teacher.register');
    Route::post('/teacher/register', 'TeacherRegisterController@startPost')->name('teacher.registerPost');
});
Route::group(['middleware' => ['auth', 'teacher']], function () {
    Route::get('/teacher/profile', 'TeacherController@profile')->name('teacher.profile');
    Route::post('/teacher/profile', 'TeacherController@profilePost')->name('teacher.profile.post');
    Route::get('/teacher/classes', 'TeacherController@classes')->name('teacher.classes');
    Route::get('/teacher/classes/add', 'TeacherController@classesAdd')->name('teacher.classes.add');
    Route::post('/teacher/classes/add', 'TeacherController@classesAddPost')->name('teacher.classes.add.post');
    Route::post('/teacher/classes/add', 'TeacherController@classesAddPost')->name('teacher.classes.add.post');
    Route::get('/teacher/documents', 'TeacherController@documents')->name('teacher.documents');
    Route::get('/teacher/party', 'TeacherController@party')->name('teacher.party');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('/admin/classes', 'AdminController@classes')->name('admin.classes');
    Route::get('/admin/schools', 'AdminController@schools')->name('admin.schools');
    Route::get('/admin/teachers', 'AdminController@teachers')->name('admin.teachers');
    Route::get('/admin/emails', 'AdminController@emails')->name('admin.emails');
    Route::get('/admin/documents', 'AdminController@documents')->name('admin.documents');
    Route::get('/admin/party', 'AdminController@party')->name('admin.party');
});
