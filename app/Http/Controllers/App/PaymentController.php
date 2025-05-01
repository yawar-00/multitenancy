<?php

namespace App\Http\Controllers\app;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PaymentController extends Controller
{
    public function payment(Request $request){
         //dd($request->all());
        //  $api = new Api(env('rzr_key'),env('rzr_secret'));
        //  $paymentInfo = $api->payment->fetch($request->razorpay_payment_id);
        // we get payment info
        //  dd($request->all(),$paymentInfo);
         //when payment successfull then this function call to show success message
        if(!empty($request->razorpay_payment_id)){
         $api = new Api(env('RAZORPAY_KEY'),env('RAZORPAY_SECRET'));
         try{
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            $response = $payment->capture(['amount'=> $payment['amount']]);
            dd($response);
         }
         catch(\Exception $ex)
         {
             return $ex->getMessage();
         }
        }
    }
}
