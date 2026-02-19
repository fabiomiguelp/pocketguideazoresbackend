<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BudgetLevelController;
use App\Http\Controllers\Api\IslandController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\TripCategoryController;
use App\Http\Controllers\Api\TripController;
use Illuminate\Support\Facades\Route;

// Public auth routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/social', [SocialAuthController::class, 'handleToken']);
});

// Protected routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);

    // Trip planner reference data
    Route::get('/islands', [IslandController::class, 'index']);
    Route::get('/islands/{island}/cities', [IslandController::class, 'cities']);
    Route::get('/trip-categories', [TripCategoryController::class, 'index']);
    Route::get('/budget-levels', [BudgetLevelController::class, 'index']);

    // Trip CRUD
    Route::get('/trips', [TripController::class, 'index']);
    Route::post('/trips', [TripController::class, 'store']);
    Route::get('/trips/{trip}', [TripController::class, 'show']);
    Route::delete('/trips/{trip}', [TripController::class, 'destroy']);
});
