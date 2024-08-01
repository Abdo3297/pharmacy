<?php

use App\Http\Controllers\Api\SocialiteAuthenticationController;
use App\Http\Controllers\Api\StripeController;
use Illuminate\Support\Facades\Route;

//###########################################################################################
//###########################################################################################
//# start point of project ##
Route::get('/', function () {
    return redirect('admin/login');
});
//###########################################################################################
//###########################################################################################
/* Google Login Module */
Route::controller(SocialiteAuthenticationController::class)
    ->group(function () {
        Route::get('auth/google', 'redirectToGoogle');
        Route::get('auth/google/callback', 'handleGoogleCallback');
    });
//###########################################################################################
//###########################################################################################
/* Stripe Module */
Route::controller(StripeController::class)
    ->group(function () {
        Route::get('stripe/{id}', 'stripe');
        Route::get('success', 'success')->name('stripe.success');
        Route::get('cancel', 'cancel')->name('stripe.cancel');
    });
//###########################################################################################
//###########################################################################################
