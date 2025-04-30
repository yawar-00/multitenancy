<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\app\UserController;
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
])->group(function () {
    Route::get('/', function () {
        return view('app.userpage');
        
    });

   Route::get('login',function(){
    return view('app.auth.login');
   });

//    Route::get('user',function(){
//     return view('app.users.index');
//    });

   Route::resource('users',UserController::class)->middleware(['auth', 'verified']);
   
//    Route::get('/welcome',function(){
//     return view('app.userpage');
//    });

   require __DIR__.'/tenant-auth.php';

   
   
    

});