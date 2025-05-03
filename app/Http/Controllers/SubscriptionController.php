<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Razorpay\Api\Api;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(){
        $plan= Plan::with('features')->get();
        // dd($plan);
        return view('subscribe',compact('plan'));
    }
    public function BuyNow($id)
    {
        $plan = Plan::findOrFail($id);
    
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        
        $razorpayOrder = $api->order->create([
            'receipt' => 'rcptid_' . $plan->id,
            'amount' => intval($plan->price * 100), // Amount in paise
            'currency' => 'INR'
        ]);
        $order_id = $razorpayOrder['id'];
    
        return view('payment', compact('plan', 'order_id'));
    }
    
 
}
