<?php

use App\Http\Controllers\app\Auth\AuthenticatedSessionController;
use App\Http\Controllers\app\Auth\ConfirmablePasswordController;
use App\Http\Controllers\app\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\app\Auth\EmailVerificationPromptController;
use App\Http\Controllers\app\Auth\NewPasswordController;
use App\Http\Controllers\app\Auth\PasswordController;
use App\Http\Controllers\app\Auth\PasswordResetLinkController;
use App\Http\Controllers\app\Auth\RegisteredUserController;
use App\Http\Controllers\app\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('tenantregister', [RegisteredUserController::class, 'create'])
                ->name('tenantregister');

    Route::post('tenantregister', [RegisteredUserController::class, 'store']);

    Route::get('tenantlogin', [AuthenticatedSessionController::class, 'create'])
                ->name('tenantlogin');

    Route::post('tenantlogin', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('tenantlogout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('tenantlogout');
});