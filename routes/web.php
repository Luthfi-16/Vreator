<?php

//admin
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TemplateController as AdminTemplateController;
use App\Http\Controllers\Admin\SoftwareController as AdminSoftwareController;
use App\Http\Controllers\Admin\TemplateCategoryController as AdminTemplateCategoryController;


//creator
use App\Http\Controllers\Creator\DashboardController as CreatorDashboardController;
use App\Http\Controllers\Creator\ProfileController as CreatorProfileController;
use App\Http\Controllers\Creator\ServiceController as CreatorServiceController;
use App\Http\Controllers\Creator\TemplateController as CreatorTemplateController;


//user
use App\Http\Controllers\User\HomeController as UserHomeCotroller;
use App\Http\Controllers\User\TemplateController as UserTemplateController;
use App\Http\Controllers\User\TransactionController as UserTransactionController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\ProfileCreatorController as UserProfileCreatorController;
use App\Models\Template;
use App\Models\TemplateDownload;
use App\Models\User;
use App\Models\Service;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredTemplates = Template::with('user')
        ->where('status', 'active')
        ->latest()
        ->take(4)
        ->get();

    $creatorCount = User::where('role', 'creator')->count();
    $templateCount = Template::where('status', 'active')->count();
    $serviceCount = Service::where('status', 'active')->count();

    return view('landing', compact(
        'featuredTemplates',
        'creatorCount',
        'templateCount',
        'serviceCount'
    ));
});

Auth::routes();

Route::post('/midtrans/notification', [UserTransactionController::class, 'notification'])
    ->name('midtrans.notification');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('/service', AdminServiceController::class)->only(['index', 'update', 'destroy']);
    Route::resource('/template', AdminTemplateController::class)->only(['index', 'update', 'destroy']);
    Route::resource('/software', AdminSoftwareController::class);
    Route::resource('/template-category', AdminTemplateCategoryController::class);
});

Route::middleware(['auth', 'role:creator'])->prefix('creator')->name('creator.')->group(function () {
    Route::get('/dashboard', [CreatorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/service', CreatorServiceController::class);
    Route::resource('/template', CreatorTemplateController::class);
    Route::get('/profile', [CreatorProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [CreatorProfileController::class, 'update'])->name('profile.update');

});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [UserHomeCotroller::class, 'index'])->name('home');
    Route::get('/template', [UserTemplateController::class, 'index'])->name('listtemplate');
    Route::get('/template/{template}', [UserTemplateController::class, 'show'])->name('template.show');
    Route::get('/template/{template}/download', [UserTemplateController::class, 'download'])->name('template.download');
    Route::post('/{template}/rate', [UserTemplateController::class, 'rate'])->name('template.rate')->middleware('auth');
    Route::post('/checkout/{template}', [UserTransactionController::class, 'checkout'])->middleware('auth')->name('checkout.template');
    Route::get('/transactions', [UserTransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{transaction}/resume', [UserTransactionController::class, 'resume'])->name('transactions.resume');
    Route::get('/payment/success', [UserTransactionController::class, 'success'])
    ->name('payment.success');
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/creator/{creator:slug}', [UserProfileCreatorController::class, 'index'])->name('creator-profile');
});
