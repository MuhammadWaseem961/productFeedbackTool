<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{UserController,ApiController,FeedbackController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// user related routes
Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('profile', 'profile');
    Route::post('update/password', 'changePasswrd');
});

Route::controller(ApiController::class)->group(function () {
    Route::get('products', 'products');
    Route::get('products/{slug}/detail', 'productDetail');
});
Route::controller(FeedbackController::class)->group(function () {
    Route::post('feedbacks/store', 'store');
    Route::get('user/feedbacks', 'userFeedbacks');
});
