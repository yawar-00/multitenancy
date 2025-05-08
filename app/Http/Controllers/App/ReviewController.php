<?php

namespace App\Http\Controllers\app;

use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ReviewController extends Controller
{
    // Store a new review
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'review_images' => 'nullable|array', // Make images an optional array
            'review_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate images
        ]);

        // Create the review
        $review = Review::create([
            'product_id' => $request->product_id,
            'title' => $request->title,
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        // If images are uploaded, handle the image storage
        if ($request->hasFile('review_images')) {
            foreach ($request->file('review_images') as $image) {
                // Generate a unique file name and store the image
                $name_gen = uniqid() . '.' . $image->getClientOriginalExtension();
                $manager = new ImageManager(new Driver());
                $img = $manager->read($image);
                $img->resize(800, 400);
                $img->save(public_path('Upload/ReviewImages/' . $name_gen));

                // Store the image path
                $save_url = 'Upload/ReviewImages/' . $name_gen;
                ReviewImage::create([
                    'review_id' => $review->id,
                    'image_path' => $save_url
                ]);
            }

            // Store image paths in the review
            
        }

        return redirect()->back();
    }

    // Update an existing review
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'rating' => 'sometimes|integer|min:1|max:5',
        ]);

        $review->update($request->only('title', 'content', 'rating'));

        return response()->json(['message' => 'Review updated successfully.', 'review' => $review]);
    }

    // Delete a review
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully.']);
    }
}
