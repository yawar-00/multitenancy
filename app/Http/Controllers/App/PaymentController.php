<?php

namespace App\Http\Controllers\app;

use Stripe\Stripe;
use App\Models\User;
use Stripe\Checkout\Session;
use App\Mail\PaymentSuccessMail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;



class PaymentController extends Controller
{
    // public function payment(Request $request){
    //      //dd($request->all());
    //     //  $api = new Api(env('rzr_key'),env('rzr_secret'));
    //     //  $paymentInfo = $api->payment->fetch($request->razorpay_payment_id);
    //     // we get payment info
    //     //  dd($request->all(),$paymentInfo);
    //      //when payment successfull then this function call to show success message
    //     if(!empty($request->razorpay_payment_id)){
    //      $api = new Api(env('RAZORPAY_KEY'),env('RAZORPAY_SECRET'));
    //      try{
    //         $payment = $api->payment->fetch($request->razorpay_payment_id);
    //         $response = $payment->capture(['amount'=> $payment['amount']]);
    //         dd($response);
    //      }
    //      catch(\Exception $ex)
    //      {
    //          return $ex->getMessage();
    //      }
    //     }
    // }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $product = \App\Models\ProductsModel::findOrFail($request->product_id);
    
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'inr',
                    'unit_amount'  => intval($product->price *100),
                    'product_data' => [
                        'name' => $product->name,
                    ],
                ],
                'quantity' => $request->quantity,
            ]],
            'mode'        => 'payment',
            'success_url' => url('/success') . '?payment=success&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => url('/cancel') . '?payment=cancel',
        ]);
    
        // Optional: Store session_id to validate later
        // dd( auth()->user()->email);
        session(['stripe_session_id' => $session->id, 'email_for_thankyou' => auth()->user()->email]);
    
        return redirect($session->url);
    }
}
