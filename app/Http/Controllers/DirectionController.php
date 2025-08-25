<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DirectionController extends Controller
{
    // List all directions (optionally by user)
    public function index(Request $request)
    {
        $query = Direction::query();
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        $directions = $query->get();
        return response()->json($directions);
    }

    // Show a single direction
    public function show($id)
    {
        $direction = Direction::find($id);
        if (!$direction) {
            return response()->json(['message' => 'Direction not found'], 404);
        }
        return response()->json($direction);
    }

    // Create a new direction
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nombre' => 'nullable|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'codigo_postal' => 'nullable|string|max:255',
            'pais' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
        ]);
        $direction = Direction::create($validated);
        return response()->json($direction, 201);
    }

    // Update an existing direction
    public function update(Request $request, $id)
    {
        $direction = Direction::find($id);
        if (!$direction) {
            return response()->json(['message' => 'Direction not found'], 404);
        }
        $validated = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'direccion' => 'sometimes|string|max:255',
            'ciudad' => 'sometimes|string|max:255',
            'region' => 'sometimes|string|max:255',
            'codigo_postal' => 'nullable|string|max:255',
            'pais' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
        ]);
        $direction->update($validated);
        return response()->json($direction);
    }

    // Delete a direction
    public function destroy($id)
    {
        $direction = Direction::find($id);
        if (!$direction) {
            return response()->json(['message' => 'Direction not found'], 404);
        }
        $direction->delete();
        return response()->json(['message' => 'Direction deleted']);
    }
}
