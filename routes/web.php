<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TemplateController as AdminTemplateController;
use App\Http\Controllers\Creator\ServiceController as CreatorServiceController;
use App\Http\Controllers\Creator\TemplateController as CreatorTemplateController;
use App\Http\Controllers\Creator\ProfileController as CreatorProfileController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('/service', AdminServiceController::class)->only(['index', 'update', 'destroy']);
    Route::resource('/template', AdminTemplateController::class)->only(['index', 'update', 'destroy']);

});

Route::middleware(['auth', 'role:creator'])->prefix('creator')->name('creator.')->group(function () {
    Route::get('/dashboard', fn() => view('creator.dashboard'))->name('dashboard');
    Route::resource('/service', CreatorServiceController::class);
    Route::resource('/template', CreatorTemplateController::class);
    Route::get('/profile', [CreatorProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [CreatorProfileController::class, 'update'])->name('profile.update');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

