<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //menampilkan semua data buku
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    //menampilkan post baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
        ]);

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    //menampilkan satu buku berdasarkan id
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book, 200);
    }

    //memperbarui buku
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
        ]);

        $book->update($validated);
        return response()->json($book, 200);
    }

    //menghapus buku
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
