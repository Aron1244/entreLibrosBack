<?php

namespace App\Http\Controllers;

use App\Models\ReadingProgress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReadingProgressController extends Controller
{
    // List all reading progress (optionally by user or book)
    public function index(Request $request)
    {
        $query = ReadingProgress::query();
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->has('book_id')) {
            $query->where('book_id', $request->book_id);
        }
        $progress = $query->get();
        return response()->json($progress);
    }

    // Show a single reading progress
    public function show($id)
    {
        $progress = ReadingProgress::find($id);
        if (!$progress) {
            return response()->json(['message' => 'Reading progress not found'], 404);
        }
        return response()->json($progress);
    }

    // Create a new reading progress
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'pagina_actual' => 'required|integer|min:1',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'configuracion' => 'nullable|array',
        ]);
        $progress = ReadingProgress::create($validated);
        return response()->json($progress, 201);
    }

    // Update an existing reading progress
    public function update(Request $request, $id)
    {
        $progress = ReadingProgress::find($id);
        if (!$progress) {
            return response()->json(['message' => 'Reading progress not found'], 404);
        }
        $validated = $request->validate([
            'pagina_actual' => 'sometimes|integer|min:1',
            'porcentaje' => 'sometimes|numeric|min:0|max:100',
            'configuracion' => 'nullable|array',
        ]);
        $progress->update($validated);
        return response()->json($progress);
    }

    // Delete a reading progress
    public function destroy($id)
    {
        $progress = ReadingProgress::find($id);
        if (!$progress) {
            return response()->json(['message' => 'Reading progress not found'], 404);
        }
        $progress->delete();
        return response()->json(['message' => 'Reading progress deleted']);
    }
}
