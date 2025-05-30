<?php

declare(strict_types=1);

use Stripe\Stripe;

use Illuminate\Http\Request;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\app\UserController;
use App\Http\Controllers\app\adminController;
use Stripe\Checkout\Session as StripeSession;
use App\Http\Controllers\app\BannerController;
use App\Http\Controllers\app\ReviewController;
use App\Http\Controllers\app\AboutUsController;
use App\Http\Controllers\app\PaymentController;
use App\Http\Controllers\app\FrontendController;
use App\Http\Controllers\app\ProductsController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'tenant.active',
    'check.subscription',
])->group(function () {

    Route::get('/',[FrontendController::class,'index'])->name('Home');
    Route::get('/shop',[FrontendController::class,'shop'])->name('Shop');
    Route::get('/shopByCategory/{id}',[FrontendController::class,'shopByCategory']);
    Route::get('/shopProduct/{id}',[FrontendController::class,'shopProduct']);
    Route::get('/about-us', [AboutUsController::class, 'index']);
    Route::get('/buynow/{id}',[FrontendController::class,'BuyNow'])->middleware(['auth', 'verified']);
    // Route::post('/razorpay',[PaymentController::class,'payment'])->middleware(['auth', 'verified'])->name('payment');
  

   Route::get('login',function(){
    return view('app.auth.login');
   });
   Route::get('register',function(){
    return view('app.auth.register');
   });

//    Route::get('user',function(){
//     return view('app.users.index');
//    });

   
//    Route::get('/welcome',function(){
//     return view('app.userpage');
//    });





Route::get('/product-stats', [ProductsController::class, 'getStats']);

Route::middleware(['admin'])->group(function(){
    Route::prefix('dashboard')->group(function(){
        Route::get('/', [adminController::class, 'index'])->name('AdminDashboard');
        Route::get('/products', [ProductsController::class, 'index'] )->name('products');
        Route::prefix('products')->group(function(){
            Route::get('/{id}/edit', [ProductsController::class, 'edit']);
            Route::post('/save-item', [ProductsController::class, 'store'])->name('product.store');
            Route::post('/{id}/update', [ProductsController::class, 'update'])->name('product.update');
        });
        
    });
    Route::prefix('admin')->group(function () {
        Route::get('/about-us', [AboutUsController::class, 'list'])->name('admin.about.list');
        Route::get('/about-us/{id}', [AboutUsController::class, 'getOne']);
        Route::post('/about-us/store', [AboutUsController::class, 'store'])->name('admin.about.store');
        Route::delete('/about-us/{id}', [AboutUsController::class, 'destroy']);
        Route::post('/about-us/toggle-status/{id}', [AboutUsController::class, 'toggleStatus']);
    });
});
Route::middleware(['admin'])->prefix('banners')->group(function(){
    Route::get('/',[BannerController::class,'index'])->name('bannerControl');
    Route::post('/save-item', [BannerController::class, 'store'])->name('banner.store');    
    Route::get('/{id}/edit', [BannerController::class, 'edit']);
    Route::post('/{id}/update', [BannerController::class, 'update']);
    Route::delete('/delete/{id}', [BannerController::class, 'delete']);
    Route::post('/makeActive/{id}', [BannerController::class, 'makeActive']);
});

// stripe integration 
// Route::get('success',[PaymentController::class,'success']);
Route::post('/stripe/checkout', [PaymentController::class, 'checkout']);

Route::get('/success', function (Request $request)
{
    $sessionId = $request->query('session_id');

    if (!$sessionId) {
        return redirect('/')->with('error', 'No session ID provided.');
    }

    Stripe::setApiKey(config('services.stripe.secret'));

    $session = \Stripe\Checkout\Session::retrieve($sessionId);

    $lineItems = \Stripe\Checkout\Session::allLineItems($sessionId, ['limit' => 1]);
    $line = $lineItems->data[0] ?? null;

    if ($line && auth()->check()) {
        Mail::to(auth()->user()->email)->send(
            new App\Mail\ProductPaymentSuccessMail(
                $line->description ?? 'Product',
                $session->amount_total / 100, // in INR
                $line->quantity ?? 1
            )
        );
    }


    return view('ThankYou');
});
Route::post('/reviews/store', [ReviewController::class, 'store'])->middleware('auth');

Route::delete('/products/delete/{id}', [ProductsController::class, 'delete']);


require __DIR__.'/tenant-auth.php';


});