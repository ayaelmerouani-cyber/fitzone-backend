<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursController;







Route::apiResource('equipements', EquipementController::class);


Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{role}', [UserController::class, 'getUsersByRole']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
Route::get('/stats', [EquipementController::class, 'stats']);
Route::post('/cours', [CoursController::class, 'store']);
Route::delete('/cours/{id}', [CoursController::class, 'destroy']); 
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::apiResource('equipements', \App\Http\Controllers\EquipementController::class);
Route::get('/contacts', [\App\Http\Controllers\MessageController::class, 'getContacts']);
Route::get('/messages/{user1}/{user2}', [\App\Http\Controllers\MessageController::class, 'getMessages']);
Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index']);
Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store']);
Route::post('/cours/{id}/reserve', [\App\Http\Controllers\CoursController::class, 'reserve']);
Route::post('/cours/{id}/annuler', [\App\Http\Controllers\CoursController::class, 'annuler']);
Route::apiResource('cours', \App\Http\Controllers\CoursController::class);


Route::apiResource('cours', CoursController::class);