<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LibProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LinkageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {
    Route::resource('lib-profile', LibProfileController::class);
    Route::resource('collection', CollectionController::class);
    Route::resource('book', BookController::class);
    Route::resource('journal', JournalController::class);
    Route::resource('magazine', MagazineController::class);
    Route::resource('gallery', GalleryController::class);
    Route::post('gallery-upload',[GalleryController::class, 'galleryUpload']);
    Route::resource('linkage', LinkageController::class);
    Route::resource('service', ServiceController::class);
    Route::post('service-upload', [ServiceController::class, 'serviceUpload']);
    Route::resource('faculty', FacultyController::class);
    Route::resource('user', UserController::class);
    Route::resource('comment', CommentController::class);
    Route::resource('event', EventController::class);
    Route::post('user-account', [UserController::class,'setAccount']);
    Route::post('event-upload', [EventController::class, 'eventUpload']);

    Route::post('change-password', [AuthController::class,'changePassword']);
    Route::post('update-profile', [AuthController::class,'updateProfile']);
    Route::get('report', [UserController::class,'reportUser']);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
