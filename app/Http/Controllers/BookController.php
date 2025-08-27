<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class BookController extends Controller
{
    // List all books
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    // Show a single book
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book);
    }

    // Create a new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'precio' => 'nullable|numeric',
            'imagen' => 'nullable|string',
            'editorial' => 'nullable|string|max:255',
            'autor' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'paginas' => 'nullable|integer',
            'idioma' => 'nullable|string|max:255',
            'fecha_publicacion' => 'nullable|date',
            'formato' => 'nullable|string|max:255',
            'dimensiones' => 'nullable|string|max:255',
            'peso' => 'nullable|string|max:255',
            'stock' => 'nullable|integer',
            'rating' => 'nullable|numeric',
            'reviews' => 'nullable|integer',
            'generos' => 'nullable|array',
            'tags' => 'nullable|array',
            'archivo_epub' => 'nullable|file|mimes:epub',
        ]);

        // Manejar la subida del archivo epub
        if ($request->hasFile('archivo_epub')) {
            $file = $request->file('archivo_epub');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('ebooks'), $filename);
            $validated['archivo_epub'] = 'ebooks/' . $filename;
        } else {
            unset($validated['archivo_epub']);
        }

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    // Update an existing book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        $validated = $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'precio' => 'nullable|numeric',
            'imagen' => 'nullable|string',
            'editorial' => 'nullable|string|max:255',
            'autor' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'paginas' => 'nullable|integer',
            'idioma' => 'nullable|string|max:255',
            'fecha_publicacion' => 'nullable|date',
            'formato' => 'nullable|string|max:255',
            'dimensiones' => 'nullable|string|max:255',
            'peso' => 'nullable|string|max:255',
            'stock' => 'nullable|integer',
            'rating' => 'nullable|numeric',
            'reviews' => 'nullable|integer',
            'generos' => 'nullable|array',
            'tags' => 'nullable|array',
            'archivo_epub' => 'nullable|file|mimes:epub',
        ]);

        // Manejar la subida del archivo epub en update
        if ($request->hasFile('archivo_epub')) {
            $file = $request->file('archivo_epub');
            $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('ebooks'), $filename);
            $validated['archivo_epub'] = 'ebooks/' . $filename;
        } else {
            unset($validated['archivo_epub']);
        }

        $book->update($validated);
        return response()->json($book);
    }

    // Delete a book
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        $book->delete();
        return response()->json(['message' => 'Book deleted']);
    }
}
