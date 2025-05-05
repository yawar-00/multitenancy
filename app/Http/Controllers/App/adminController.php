<?php

namespace App\Http\Controllers\app;

use Carbon\Carbon;
use App\Models\User;
use App\Models\category;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\ProductsModel;
use App\Http\Controllers\Controller;

class adminController extends Controller
{
    public function index(){
        $productscount=ProductsModel::latest()->get()->count();
        $userscount=User::latest()->get()->count();
        $categoriescount=category::get()->count();

        $subscription = Subscription::latest()->first(); // assuming one subscription per tenant

   
        $today = Carbon::now();
        $endDate = Carbon::parse($subscription->end_date);

        if ($endDate->isAfter($today) && $today->diffInDays($endDate) <= 2) {
            session()->flash('subscription_warning', '⚠️ Your subscription will expire in ' . $today->diffInDays($endDate) . ' day(s). Please renew.');
        }

        return view('app.adminDashboard',compact('productscount','userscount','categoriescount'));
    } 
    
}
