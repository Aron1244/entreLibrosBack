<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WishlistController extends Controller
{
    // List all wishlists (optionally by user)
    public function index(Request $request)
    {
        $query = Wishlist::with(['user', 'book']);
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        $wishlists = $query->get();
        return response()->json($wishlists);
    }

    // Show a single wishlist item
    public function show($id)
    {
        $wishlist = Wishlist::with(['user', 'book'])->find($id);
        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist item not found'], 404);
        }
        return response()->json($wishlist);
    }

    // Create a new wishlist item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);
        // Evitar duplicados
        $exists = Wishlist::where('user_id', $validated['user_id'])
            ->where('book_id', $validated['book_id'])
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'Book already in wishlist'], 409);
        }
        $wishlist = Wishlist::create($validated);
        return response()->json($wishlist, 201);
    }

    // Delete a wishlist item
    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);
        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist item not found'], 404);
        }
        $wishlist->delete();
        return response()->json(['message' => 'Wishlist item deleted']);
    }
}
