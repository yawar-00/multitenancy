<?php

namespace App\Http\Controllers\app;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BannerController extends Controller
{
    public function index(){
        $banners = Banner::latest()->get();
        // dd($banners);
        return view('app.banner',compact('banners'));
    }
    public function store(Request $request)
    {
     
       
        $request->validate([
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            
        ]);
        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img->save(public_path('Upload/Banner/' . $name_gen));
    
            $save_url = 'Upload/Banner/' . $name_gen;
           
            $banner = Banner::create([
                'description' => $request->description,
                'url' => $save_url,
            ]);
            
            return response()->json([
                'success' => 'Banner saved successfully.',
                'banner' => [
                    'id' => $banner->id,
                    'image' => asset($banner->url),
                    'description' => $banner->description,
                    'status' => '0',
                ]
            ]);
        }
    
        return response()->json(['error' => 'Image upload failed.'], 422);
    }
    public function makeActive(Request $request, $id)
        {
        
           
                $status = $request->status;
            
                // First, deactivate all heroes
                Banner::where('id', '!=', $id)->update(['status' => 0]);
            
                // Then activate the selected one
                $banner = Banner::findOrFail($id);
                $banner->status = $status;
                $banner->save();    
                return response()->json([
                    'message' => $status ? 'This Banner is now active. Others deactivated.' : 'Banner is now inactive.'
                ]);
            
    }
    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
    
        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }
        // Log::error("Product not found with ID: $id");
    
        // Log::info("Found product: " . $banner->image);
    
        if ($banner->image) {
            $imagePath = public_path($banner->image);
    
            if (File::exists($imagePath)) {
                File::delete($imagePath);
                // Log::info("Image deleted at: $imagePath");
            } 
        } else {
            // Log::warning("No image field for product: $id");
        }
    
        $banner->delete();
        // Log::info("Product deleted: $id");
    
        return response()->json(['success' => 'Banner deleted successfully']);
    }
}
