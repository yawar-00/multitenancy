<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[SubscriptionController::class,'index']);

Route::resource('tanent',TenantController::class)->middleware(['superadmin']);
Route::post('tanent/store',[TenantController::class,'store'])->middleware(['superadmin'])->name('tenant.store');
// Route::get('/dashboard', function () {
//     return view('tenancy.index');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/plancheckout',[PaymentController::class,'payment'])->middleware(['auth', 'verified'])->name('planPayment');
Route::get('/subscribe', [SubscriptionController::class,'index']);
require __DIR__.'/auth.php';