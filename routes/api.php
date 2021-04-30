<?php

use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/loggedinuser', [AuthController::class, 'loggedinUser']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/allArtists', [AuthController:: class, 'showArtist']);
    Route::get('/getArtist/{id}', [AuthController:: class, 'showArtistById']);
});
Route::post('/addContent', [ContentController:: class, 'addContent']);
Route::post('/subscriber', [SubscriberController:: class, 'subscribe']);
Route::get('/getContent/{postedBy}', [ContentController:: class, 'showContentByPostedBy']);

