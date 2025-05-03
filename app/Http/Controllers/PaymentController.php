<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Mail\PaymentSuccessMail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function payment(Request $request){
        //  dd($request);
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
            $validData=$request->validate([
                'name'=>'required|string|max:255',
                'email'=>'required|email|max:255',
                'domain'=>'required|string|max:255|unique:domains,domain',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
    
            ]);
            // dd($validData);
            $tenant = Tenant::create([
                'name' => $validData['name'],
                'email' => $validData['email'],
                'password' => $validData['password'],
            ]);
            
            $tenant->domains()->create([
                'domain'=>$validData['domain'].'.'.config('app.domain')
            ]);
            $tenantData = [
                'name' => $tenant->name,
                'email' => $tenant->email,
                'domain' => $validData['domain'].'.'.config('app.domain'),
                'amount'=>$request->amount,
            ];

            Mail::to($tenant->email)->send(new PaymentSuccessMail($tenantData));

            dd('Successfully done');
         }
         catch(\Exception $ex)
         {
            return $ex->getMessage();
         }
        }
    }
}
