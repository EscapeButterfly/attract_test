<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [AuthController::class, 'resend'])->name('verification.resend');

Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('profile/{id}', [UserController::class, 'profile'])->name('users.profile');
        Route::post('subscribe', [UserController::class, 'subscribe'])->name('users.subscribe');
    });

    Route::prefix('posts')->group(function () {
        Route::post('create', [PostController::class, 'create'])->name('posts.create');
        Route::get('{id}/comments', [PostController::class, 'getComments'])->name('posts.get_comments');
        Route::post('{id}/comment', [PostController::class, 'addComment'])->name('posts.add_comment');
        Route::get('hot', [PostController::class, 'hot'])->name('posts.hot');
    });

    Route::post('logout', [AuthController::class, 'logout']);
});
