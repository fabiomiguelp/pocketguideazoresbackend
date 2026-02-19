<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BudgetLevelController;
use App\Http\Controllers\Admin\CityGemController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\IslandController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TripCategoryController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\UserManagementController;

// Public auth routes
Route::get('/auth-signin', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/auth-signin', [AuthController::class, 'login']);
Route::post('/auth-logout', [AuthController::class, 'logout'])->name('logout');

// Static auth views
Route::get('/auth-signup', function () { return view('auth-signup'); });
Route::get('/auth-forgot-password', function () { return view('auth-forgot-password'); });

// Protected admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User management CRUD
    Route::resource('admin/users', UserManagementController::class)
        ->except(['show'])
        ->names('admin.users');

    // Trip planner management
    Route::resource('admin/islands', IslandController::class)
        ->except(['show'])
        ->names('admin.islands');

    Route::resource('admin/cities', CityController::class)
        ->except(['show'])
        ->names('admin.cities');

    Route::resource('admin/trip-categories', TripCategoryController::class)
        ->except(['show'])
        ->names('admin.trip-categories');

    Route::resource('admin/budget-levels', BudgetLevelController::class)
        ->except(['show'])
        ->names('admin.budget-levels');

    Route::resource('admin/city-gems', CityGemController::class)
        ->except(['show'])
        ->names('admin.city-gems');

    Route::resource('admin/partners', PartnerController::class)
        ->except(['show'])
        ->names('admin.partners');

    // Trips (view only - index, show, delete)
    Route::get('admin/trips', [TripController::class, 'index'])->name('admin.trips.index');
    Route::get('admin/trips/{trip}', [TripController::class, 'show'])->name('admin.trips.show');
    Route::delete('admin/trips/{trip}', [TripController::class, 'destroy'])->name('admin.trips.destroy');

    // Catch-all for Urbix template pages (must be LAST)
    Route::get('{any}', [DashboardController::class, 'index'])->where('any', '.*');
});
