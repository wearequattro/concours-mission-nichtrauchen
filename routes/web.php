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
    Route::get('/teacher/party/{class}', 'TeacherController@partyClass')->name('party.class');
    Route::post('/teacher/party/{class}', 'TeacherController@partyClassPost')->name('party.class.post');
});

Route::get('/suivi/{token}/{status}', 'FollowUpController@setFollowUpStatus')->name('follow-up');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('/admin/classes', 'SchoolClassController@classes')->name('admin.classes');
        Route::get('/admin/classes/{class}', 'SchoolClassController@classesEdit')->name('admin.classes.edit');
        Route::post('/admin/classes/{class}', 'SchoolClassController@classesEditPost')->name('admin.classes.edit.post');

        Route::get('/admin/schools', 'SchoolController@schools')->name('admin.schools');
        Route::get('/admin/schools/{school}', 'SchoolController@schoolsEdit')->name('admin.schools.edit');
        Route::post('/admin/schools/{school}', 'SchoolController@schoolsEditPost')->name('admin.schools.edit.post');

        Route::get('/admin/teachers', 'TeacherController@teachers')->name('admin.teachers');
        Route::get('/admin/teachers/{teacher}', 'TeacherController@teachersEdit')->name('admin.teachers.edit');
        Route::post('/admin/teachers/{teacher}', 'TeacherController@teachersEditPost')->name('admin.teachers.edit.post');

        Route::get('/admin/emails', 'EmailController@emails')->name('admin.emails');
        Route::get('/admin/emails/{email}', 'EmailController@emailsEdit')->name('admin.emails.edit');
        Route::post('/admin/emails/{email}', 'EmailController@emailsEditPost')->name('admin.emails.edit.post');

        Route::get('/admin/documents', 'DocumentController@documents')->name('admin.documents');
        Route::post('/admin/documents', 'DocumentController@documentsPost')->name('admin.documents.post');
        Route::get('/admin/documents/{document}/visibility', 'DocumentController@documentsToggleVisibility')->name('admin.documents.toggleVisibility');
        Route::get('/admin/documents/{document}/download', 'DocumentController@documentsDownload')->name('admin.documents.download');
        Route::get('/admin/documents/{document}/delete', 'DocumentController@documentsDelete')->name('admin.documents.delete');

        Route::get('/admin/party', 'PartyController@party')->name('admin.party');
    });
});
