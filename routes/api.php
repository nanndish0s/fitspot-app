<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GymController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['web', 'auth'])->group(function () {
    // Chat routes
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('api.chat.send');
    Route::get('/chat/conversation/{otherUserId}', [ChatController::class, 'getConversation'])->name('api.chat.conversation');
    Route::post('/chat/mark-read/{otherUserId}', [ChatController::class, 'markAsRead'])->name('api.chat.mark-read');
});

// Gym Routes
Route::get('/gyms/nearby', [GymController::class, 'nearbyGyms']);
Route::get('/gyms/{gym}', [GymController::class, 'show']);
