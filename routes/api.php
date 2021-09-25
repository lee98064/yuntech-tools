<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\OverFlowNotificationController;
use App\Http\Controllers\API\LineNotifyController;
use App\Http\Controllers\API\WebNotifyController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/user', function () {
//     return Auth::user()->toJson();
// });

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('user', [UserController::class, 'getuser'])->middleware('auth:sanctum');


Route::resource('overflownotification', OverFlowNotificationController::class)->middleware('auth:sanctum');
Route::resource('linenotify', LineNotifyController::class)->middleware('auth:sanctum');
// Route::post('linenotify', [LineNotifyController::class, 'store']);
Route::resource('webnotify', WebNotifyController::class)->middleware('auth:sanctum');
