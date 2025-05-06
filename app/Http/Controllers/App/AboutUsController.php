<?php
namespace App\Http\Controllers\app;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
{
    $about = AboutUs::where('status', true)->first();
    return view('app.front-end.AboutUs', compact('about'));
}
    public function list()
    {
        $abouts = AboutUs::latest()->get();
        return view('app.AdminAboutUs', compact('abouts'));
    }

    public function getOne($id)
    {
        return response()->json(AboutUs::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'id' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        $about = AboutUs::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return response()->json(['success' => true, 'about' => $about]);
    }

    public function destroy($id)
    {
        $about = AboutUs::findOrFail($id);
        if ($about->image) Storage::disk('public')->delete($about->image);
        $about->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $about = AboutUs::findOrFail($id);

        if (!$about->status) {
            AboutUs::query()->update(['status' => false]);
            $about->status = true;
        } else {
            $about->status = false;
        }

        $about->save();
        return response()->json(['message' => 'Status updated']);
    }
}
