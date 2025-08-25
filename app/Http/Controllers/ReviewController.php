<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    // List all reviews (optionally by book or user)
    public function index(Request $request)
    {
        $query = Review::with(['user', 'book']);
        if ($request->has('book_id')) {
            $query->where('book_id', $request->book_id);
        }
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        $reviews = $query->get();
        return response()->json($reviews);
    }

    // Show a single review
    public function show($id)
    {
        $review = Review::with(['user', 'book'])->find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        return response()->json($review);
    }

    // Create a new review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|numeric|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);
        // Evitar duplicados (un usuario solo puede dejar una reseña por libro)
        $exists = Review::where('user_id', $validated['user_id'])
            ->where('book_id', $validated['book_id'])
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'Review already exists for this book'], 409);
        }
        $review = Review::create($validated);
        return response()->json($review, 201);
    }

    // Update an existing review
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        $validated = $request->validate([
            'rating' => 'sometimes|numeric|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);
        $review->update($validated);
        return response()->json($review);
    }

    // Delete a review
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }
        $review->delete();
        return response()->json(['message' => 'Review deleted']);
    }
}
