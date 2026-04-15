<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Creator\DashboardController as CreatorDashboardController;
use App\Http\Controllers\Api\Creator\ServiceController as CreatorServiceController;
use App\Http\Controllers\Api\Creator\TemplateController as CreatorTemplateController;
use App\Http\Controllers\Api\LookupController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\User\CreatorController as UserCreatorController;
use App\Http\Controllers\Api\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Api\User\TemplateController as UserTemplateController;
use App\Http\Controllers\Api\User\TransactionController as UserTransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/template-categories', [LookupController::class, 'categories']);
Route::get('/softwares', [LookupController::class, 'softwares']);
Route::get('/templates', [UserTemplateController::class, 'index']);
Route::get('/templates/{template}', [UserTemplateController::class, 'show']);
Route::get('/creators/{creator}', [UserCreatorController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile', [ProfileController::class, 'update']);

    Route::resource('/posts', \App\Http\Controllers\Api\PostController::class); // tambahkan ini
});

Route::middleware(['auth:sanctum', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', UserDashboardController::class);
    Route::get('/transactions', [UserTransactionController::class, 'index']);
    Route::post('/templates/{template}/checkout', [UserTransactionController::class, 'checkout']);
    Route::post('/transactions/{transaction}/resume', [UserTransactionController::class, 'resume']);
    Route::post('/templates/{template}/rate', [UserTemplateController::class, 'rate']);
    Route::post('/templates/{template}/download', [UserTemplateController::class, 'download']);
});

Route::middleware(['auth:sanctum', 'role:creator'])->prefix('creator')->group(function () {
    Route::get('/dashboard', CreatorDashboardController::class);
    Route::apiResource('/services', CreatorServiceController::class);
    Route::apiResource('/templates', CreatorTemplateController::class);
});
