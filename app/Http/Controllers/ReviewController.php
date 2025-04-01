<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\ReviewImage;
use App\Models\Item;


class ReviewController extends Controller
{
    public function index()
    {
        $customer_id = auth()->user()->customer->customer_id;

        $reviews = Review::withTrashed() 
        ->with(['item', 'images']) 
        ->where('customer_id', $customer_id)
        ->latest()
        ->get();

        return view('review.index', compact('reviews'));
    }


    public function addReview($orderId)
    {
        $order = DB::table('orderinfo')->where('orderinfo_id', $orderId)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $items = DB::table('orderline')
            ->join('item', 'orderline.item_id', '=', 'item.item_id')
            ->where('orderline.orderinfo_id', $orderId)
            ->select('item.item_id', 'item.item_name')
            ->get();

        foreach ($items as $item) {
            $item->images = DB::table('item_images')
                ->where('item_id', $item->item_id)
                ->pluck('image_path');
        }




        return view('review.create', compact('order', 'items'));
    }

    public function store(Request $request)
    {
        $rules = [
            'item_id' => 'required|exists:item,item_id',
            'orderinfo_id' => 'required|exists:orderinfo,orderinfo_id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string',
            'media_files.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,mp4,webm,mov|max:20480',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer_id = auth()->user()->customer->customer_id;

        $review = Review::create([
            'customer_id'   => $customer_id,
            'orderinfo_id'  => $request->orderinfo_id,
            'item_id'       => $request->item_id,
            'rating'        => $request->rating,
            'review_text'   => trim($request->review_text),
        ]);

        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = Storage::putFileAs(
                    'public/review_media',
                    $file,
                    $file->hashName()
                );

                ReviewImage::create([
                    'review_id'  => $review->review_id,
                    'item_id'    => $request->item_id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('reviews.index')->with('success', 'Review submitted successfully!');
    }

    public function edit(string $id)
    {
        $review = DB::table('reviews')
            ->join('item', 'reviews.item_id', '=', 'item.item_id')
            ->where('reviews.review_id', $id)
            ->select(
                'reviews.review_id',
                'reviews.item_id',
                'reviews.rating',
                'reviews.review_text',
                'item.item_name'
            )
            ->first();


        return view('review.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string',
            'media_files.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240'
        ]);

        $review = Review::findOrFail($id);
        $review->rating = $request->rating;
        $review->review_text = $request->review_text;
        $review->save();

        if ($request->hasFile('media_files')) {
            $oldMedia = ReviewImage::where('review_id', $review->review_id)->get();
            foreach ($oldMedia as $media) {
                if (Storage::exists($media->image_path)) {
                    Storage::delete($media->image_path);
                }
            }
    
            // Delete old media records
            ReviewImage::withTrashed()->where('review_id', $review->review_id)->forceDelete();
    
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('public/review_media');
                ReviewImage::create([
                    'review_id' => $review->review_id,
                    'image_path' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(string $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return redirect()->back()->with('error', 'Review not found.');
        }

        $review->images()->delete();
        $review->delete();

        $redirectRoute = auth()->user()->role === 'Admin' ? 'admin.reviews' : 'reviews.index';

    return redirect()->route($redirectRoute)->with('success', 'Review deleted successfully!');
    }

    public function restore($id)
    {
        $review = Review::onlyTrashed()->where('review_id', $id)->first();

        if (!$review) {
            return redirect()->back()->with('error', 'Review not found in trash.');
        }

        $review->restore();
        $review->images()->onlyTrashed()->restore();

        $redirectRoute = auth()->user()->role === 'Admin' ? 'admin.reviews' : 'reviews.index';

    return redirect()->route($redirectRoute)->with('success', 'Review restored successfully!');
    }
}
