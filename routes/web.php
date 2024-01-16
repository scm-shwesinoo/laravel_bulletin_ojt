<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
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

Auth::routes(['register' => false]);

Route::get('/', function () {
  return redirect()->route('postlist');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

// vistor, user, admin authorized
Route::get('/post/list', [PostController::class, 'showPostList'])->name('postlist');
Route::get('/post/download', [PostController::class, 'downloadPostCSV'])->name('downloadPostCSV');

Route::get('file-import-export', [PostController::class, 'fileImportExport']);
Route::post('file-import', [PostController::class, 'fileImport'])->name('file-import');

// user, admin authorized
Route::group(['middleware' => ['auth']], function () {
  Route::get('/post/create', [PostController::class, 'showPostCreateView'])->name('create.post');
  Route::post('/post/create', [PostController::class, 'submitPostCreateView'])->name('create.post');
  Route::get('/post/create/confirm', [PostController::class, 'showPostCreateConfirmView'])->name('post.create.confirm');
  Route::post('/post/create/confirm', [PostController::class, 'submitPostCreateConfirmView'])->name('post.create.confirm');
  Route::delete('/post/delete/{postId}', [PostController::class, 'deletePostById']);
  Route::get('/post/edit/{postId}', [PostController::class, 'showPostEdit'])->name('post.edit');
  Route::post('/post/edit/{postId}', [PostController::class, 'submitPostEditView'])->name('post.edit');
  Route::get('/post/edit/{postId}/confirm', [PostController::class, 'showPostEditConfirmView'])->name('post.edit.confirm');
  Route::post('/post/edit/{postId}/confirm', [PostController::class, 'submitPostEditConfirmView'])->name('post.edit.confirm');
  Route::get('/post/upload', [PostController::class, 'showPostUploadView'])->name('post.upload');
  Route::post('/post/upload', [PostController::class, 'submitPostUploadView'])->name('post.upload');
});

// user, admin authorized
Route::group(['middleware' => ['auth']], function () {
  Route::get('/user/profile', [UserController::class, 'showUserProfile'])->name('profile');
  Route::get('/user/profile/edit', [UserController::class, 'showUserProfileEdit'])->name('profile.edit');
  Route::post('/user/profile/edit', [UserController::class, 'submitEditProfileView'])->name('profile.edit');
  Route::get('/user/profile/edit/confirm', [UserController::class, 'showEditProfileConfirmView'])->name('profile.edit.confirm');
  Route::post('/user/profile/edit/confirm', [UserController::class, 'submitProfileEditConfirmView'])->name('profile.edit.confirm');
  Route::get('/user/change-password', [UserController::class, 'showChangePasswordView'])->name('change.password');
  Route::post('/user/change-password', [UserController::class, 'savePassword'])->name('change.password');
});

// only admin authorized
Route::group(['middleware' => ['admin']], function () {
  Route::get('/user/list', [UserController::class, 'showUserList'])->name('userlist');
  Route::get('/user/register', [RegisterController::class, 'showRegistrationView'])->name('register');
  Route::post('/user/register', [RegisterController::class, 'submitRegistrationView'])->name('register');
  Route::get('user/register/confirm', [RegisterController::class, 'showRegistrationConfirmView'])->name('register.confirm');
  Route::post('user/register/confirm', [RegisterController::class, 'submitRegistrationConfirmView'])->name('register.confirm');
  Route::delete('/user/delete/{userId}', [UserController::class, 'deleteUserById']);
});
