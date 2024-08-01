<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PrivacyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\TermController;
use Illuminate\Support\Facades\Route;

//###########################################################################################
//###########################################################################################
/* Authentication Module */

Route::middleware(['appLang'])
    ->controller(AuthenticationController::class)
    ->group(function () {
        Route::post('/register', 'register');
        Route::post('/checkRegisterOTP', 'checkRegisterOTP');
        Route::post('/sendOTP', 'sendOTP');
        Route::post('/checkOTP', 'checkOTP');
        Route::post('/resetPassword', 'resetPassword');
        Route::post('/loginEmail', 'loginEmail');
        Route::post('/loginPhone', 'loginPhone');
    });
Route::middleware(['auth:sanctum', 'appLang'])
    ->controller(AuthenticationController::class)
    ->group(function () {
        Route::post('/logout', 'logoutFromCurrentDevices');
        Route::post('/logoutFromAllDevices', 'logoutFromAllDevices');
        Route::post('/updateProfile', 'updateProfile');
        Route::post('/changePassword', 'changePassword');
        Route::post('/deleteProfile', 'deleteProfile');
    });
//###########################################################################################
//###########################################################################################
/* Category Module */
Route::middleware(['appLang'])
    ->controller(CategoryController::class)
    ->group(function () {
        Route::get('/getCategoryList', 'index');
        Route::get('/getCategoryDetails/{id}', 'show');
    });
//###########################################################################################
//###########################################################################################
/* Product Module */
Route::middleware(['appLang'])
    ->controller(ProductController::class)
    ->group(function () {
        Route::get('/getProductList', 'index');
        Route::get('/getProductDetails/{id}', 'show');
    });
Route::middleware(['appLang', 'auth:sanctum'])
    ->controller(ProductController::class)
    ->group(function () {
        Route::post('/suggestsForYou', 'suggestsForYou');
    });
//###########################################################################################
//###########################################################################################
/* Favourite Module */
Route::middleware(['auth:sanctum', 'appLang'])
    ->controller(FavouriteController::class)
    ->group(function () {
        Route::get('/displayFavouriteProduct', 'displayFavouriteProduct');
        Route::post('/toggleFavourite', 'toggleFavourite');
    });
//###########################################################################################
//###########################################################################################
/* Settings Module */
Route::prefix('/settings')->group(function () {
    //##################################################################
    //##################################################################
    /* Onboarding Part */
    Route::controller(SettingController::class)->group(function () {
        Route::get('/getOnboarding', 'getOnboarding');
    });
    /* Carousel Part */
    Route::controller(SettingController::class)->group(function () {
        Route::get('/getpharmacyCarousel', 'getpharmacyCarousel');
    });
    //##################################################################
    //##################################################################
    /* Language Part */
    Route::controller(SettingController::class)->group(function () {
        Route::get('/getAvailableLanguage', 'getAvailableLanguage');
        Route::post('/changeLanguage', 'changeLanguage');
    });
    //##################################################################
    //##################################################################
    /* Contact Part */
    Route::middleware(['auth:sanctum', 'appLang'])
        ->controller(SettingController::class)->group(function () {
            Route::post('/contactUs', 'contactUs');
        });
    //##################################################################
    //##################################################################
    /* About Part */
    Route::middleware(['appLang'])
        ->controller(AboutController::class)
        ->group(function () {
            Route::get('/getAboutList', 'index');
        });
    //##################################################################
    //##################################################################
    /* Privacy Part */
    Route::middleware(['appLang'])
        ->controller(PrivacyController::class)
        ->group(function () {
            Route::get('/getPrivacyList', 'index');
        });
    //##################################################################
    //##################################################################
    /* Faq Part */
    Route::middleware(['appLang'])
        ->controller(FaqController::class)
        ->group(function () {
            Route::get('/getFaqList', 'index');
        });
    //##################################################################
    //##################################################################
    /* Term Part */
    Route::middleware(['appLang'])
        ->controller(TermController::class)
        ->group(function () {
            Route::get('/getTermList', 'index');
        });
    //##################################################################
    //##################################################################
});
//###########################################################################################
//###########################################################################################
/* Order Module */
Route::middleware(['auth:sanctum', 'appLang'])
    ->controller(OrderController::class)
    ->group(function () {
        Route::get('/getOrderList', 'index');
        Route::get('/getOrderDetails/{id}', 'show');
        Route::post('/storeOrder', 'store');
        Route::post('/updateOrder/{id}', 'update');
        Route::post('/deleteOrder/{id}', 'destroy');
    });
//###########################################################################################
//###########################################################################################
/* Invoice Module */
Route::middleware(['auth:sanctum', 'appLang'])
    ->controller(InvoiceController::class)
    ->group(function () {
        Route::get('/downloadInvoice/{orderId}', 'index');
    });
//###########################################################################################
//###########################################################################################
/* Chat Module */
Route::middleware(['auth:sanctum', 'appLang'])
    ->controller(ChatController::class)
    ->group(function () {
        Route::get('/loadChat', 'loadChat');
        Route::post('/sendMessage', 'sendMessage');
        Route::post('/downloadFile/{messageId}', 'downloadFile');
        Route::post('/markAsRead', 'markAsRead');
    });
//###########################################################################################
//###########################################################################################
/* Notification Module */
Route::middleware(['auth:sanctum'])
    ->controller(NotificationController::class)
    ->group(function () {
        Route::post('/markAllNotificationsAsRead', 'markAllNotificationsAsRead');
        Route::post('/markNotificationAsRead/{id}', 'markNotificationAsRead');
        Route::post('/clearAllNotifications', 'clearAllNotifications');
        Route::post('/clearNotification/{id}', 'clearNotification');
    });
