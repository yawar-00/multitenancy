<?php

namespace App\Http\Controllers\app;

use Razorpay\Api\Api;

use App\Models\Banner;
use App\Models\Review;
use App\Models\category;
use Illuminate\Http\Request;
use App\Models\ProductsModel;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
   public function index(){
      $categories =category::get();
        $activeImage = Banner::where('status', '1')->first();
         $products = ProductsModel::latest()->get();
        return view('app.welcome',compact('activeImage','categories','products'));
   }
   public function shop(){
      $products = ProductsModel::with(['category'])->latest()->get();
      return view('app.front-end.Shop',compact('products'));
   }
   public function shopByCategory($id){
     
      $products = ProductsModel::where('category_id',$id)->latest()->get();
     
      return view('app.front-end.Shop',compact('products'));
      
      
   }
   public function shopProduct($id){
      $product = ProductsModel::findOrFail($id);
      $reviews = Review::where('product_id',$id)->with('images')->get();
      // dd($reviews);
      return view('app.front-end.ShopProduct',compact('product','reviews'));
      
      
   }
   public function BuyNow($id)
   {
       $product = ProductsModel::findOrFail($id);
   
       $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
       
       $razorpayOrder = $api->order->create([
           'receipt' => 'rcptid_' . $product->id,
           'amount' => intval($product->price * 100), // Amount in paise
           'currency' => 'INR'
       ]);
   
       $order_id = $razorpayOrder['id'];
   
       return view('app.front-end.payment', compact('product', 'order_id'));
   }
   
}
