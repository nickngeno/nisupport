<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SubscriberController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/allArtists', [AuthController:: class, 'showArtist']);
    Route::get('/getArtist/{id}', [AuthController:: class, 'showArtistById']);
});
Route::post('/addContent', [ContentController:: class, 'addContent']);
Route::post('/subscriber', [SubscriberController:: class, 'subscribe']);
Route::get('/getContent/{postedBy}', [ContentController:: class, 'showContentByPostedBy']);

;


