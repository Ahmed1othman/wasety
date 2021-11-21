<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\CitiesController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PayPalPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NotificationsController;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {


    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('partners-active', [PartnerController::class,'changeStatus']);
    Route::resource('partners', PartnerController::class);

    Route::resource('users', UserController::class);
    Route::post('users-active', [UserController::class,'changeStatus']);

    Route::resource('contacts', ContactController::class);
    Route::post('contacts-active', [ContactController::class,'changeStatus']);

    Route::resource('countries', CountriesController::class);
    Route::post('countries-active', [CountriesController::class,'changeStatus']);

    Route::resource('cities', CitiesController::class);
    Route::post('cities-active', [CitiesController::class,'changeStatus']);

    Route::resource('sliders', SliderController::class);
    Route::post('sliders-active', [SliderController::class,'changeStatus']);

    Route::resource('projects', ProjectController::class);
    Route::resource('products', ProductController::class);
    Route::get('projects-request', [ProjectController::class,'projectsRequest'])->name('projects.request');
    Route::get('projects-implementation', [ProjectController::class,'implementationProject'])->name('projects.implementation');
    Route::get('projects-delivery', [ProjectController::class,'deliveryProject'])->name('projects.delivery');
    Route::get('projects-history', [ProjectController::class,'historyProject'])->name('projects.history');
    Route::post('projects-active', [ProjectController::class,'changeStatus']);
    Route::post('accept-project/{id}', [ProjectController::class,'acceptProject']);
    Route::post('project-status/{id}', [ProjectController::class,'adminChangeStatus']);
    Route::post('reject-project/{id}', [ProjectController::class,'rejectProject']);

    Route::resource('info', InfoController::class);
    Route::get('notify/{id}/{status}', [ProjectController::class,'markAsRead'])->name('projectNotification');

    Route::resource('notifications', NotificationsController::class);

    Route::resource('payments', PayPalPaymentController::class);

});



