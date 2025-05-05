<?php

namespace App\Http\Controllers\app;



use App\Models\category;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\ProductsModel;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class ProductsController extends Controller
{


    public function index(Request $request)
    {
        $products = ProductsModel::with(['category'])->latest()->get();
        $product_used = ProductsModel::get()->count();
        $total_product = Subscription::latest()->first()->maxProducts;
        
        
      

        // dd($products);
        return view('app.products', compact('products','product_used','total_product'));
    }



    public function store(Request $request)
    {
        $products = ProductsModel::with(['category'])->latest()->get();
        $product_used = ProductsModel::get()->count();
        $total_product = Subscription::latest()->first()->maxProducts;

       if($product_used<=$total_product){
            $request->validate([
                'name' => 'required|min:1',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'category' => 'required|exists:categories,id',
                'price' => 'required|decimal:2',
            ]);
            if ($request->hasFile('image')) {
                $manager = new ImageManager(new Driver());
        
                $name_gen = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
        
                $img = $manager->read($request->file('image'));
                $img->resize(800, 400);
                $img->save(public_path('Upload/products/' . $name_gen));
        
                $save_url = 'Upload/products/' . $name_gen;
            
                $product = ProductsModel::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'image' => $save_url,
                    'category_id'=>$request->category,
                    'price'=>$request->price,
                ]);
                
                return response()->json([
                    'success' => 'Product saved successfully.',
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'image' => asset($product->image),
                        'category' =>  category::where('id',$request->category)->value('category_name'),
                        'price'=>$product->price,
                    ]
                ]);
            
            }
        
            return response()->json(['error' => 'Image upload failed.'], 422);
       }
       else{
        return response()->json(['error' => 'Product Insertion Limit Reached.'], 422);

       }
    }






    // Edit a product by its ID
    public function edit($id)
    {
        $product = ProductsModel::findOrFail($id);
    
        // Convert image path to full URL if it exists
        if ($product->image) {
            $product->image = asset($product->image);
        }
        return response()->json([
            'product' => $product
        ]);
    }
    // Update a product by its ID
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|min:1',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|exists:categories,id',
            'price' => 'required|decimal:2',
        ]);
    
        $product = ProductsModel::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->price=$request->price;
        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
    
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }

            if ($product->image) {
                $imagePath = public_path($product->image);
        
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            } 
    
            $name_gen = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img->resize(800, 400);
            $img->save(public_path('Upload/products/' . $name_gen));
    
            $save_url = 'Upload/products/' . $name_gen;
            $product->image = $save_url;
        }
    
        $product->save();
    
        return response()->json([
            'success' => 'Product updated successfully.',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'image' => asset($product->image),
                'category' =>  category::where('id',$request->category)->value('category_name'),
                'price'=>$product->price,
            ]
        ]);
    }
    

    // Delete a product by its ID
    public function delete($id)
    {
        $product = ProductsModel::find($id);
    
        if (!$product) {
            Log::error("Product not found with ID: $id");
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        Log::info("Found product: " . $product->name);
    
        if ($product->image) {
            $imagePath = public_path($product->image);
    
            if (File::exists($imagePath)) {
                File::delete($imagePath);
                // Log::info("Image deleted at: $imagePath");
            } else {
                // Log::warning("Image not found at: $imagePath");
            }
        } else {
            // Log::warning("No image field for product: $id");
        }
    
        $product->delete();
        // Log::info("Product deleted: $id");
    
        return response()->json(['success' => 'Product deleted successfully']);
    }
 
    public function getStats()
{
    $products = ProductsModel::with(['category'])->latest()->get();
        $used = ProductsModel::get()->count();
        $total = Subscription::latest()->first()->maxProducts;
    $percentage = $total > 0 ? ($used / $total) * 100 : 0;

    return response()->json([
        'used' => $used,
        'total' => $total,
        'percentage' => round($percentage)
    ]);
}

}
