<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Untuk Admin
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('author', 'LIKE', "%{$search}%")
                    ->orWhere('publisher', 'LIKE', "%{$search}%")
                    ->orWhere('year', 'LIKE', "%{$search}%")
                    ->orWhere('stock', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })->orderBy('created_at', 'desc')
            ->simplePaginate(10);

        return view('admin.books.index', compact('books', 'search'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image'
        ]);

        $book = $request->only(['title', 'author', 'publisher', 'year', 'stock', 'category_id']);
        $book['slug'] = Str::slug($request->input('title'));

        if ($request->hasFile('image')) {
            $book['image'] = $request->file('image')->store('books', 'public');
        }

        Book::create($book);

        return redirect()->route('admin.book.index')->with('success', 'Buku berhasil ditambahkan');
    }


    public function edit($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        $categories = Category::all();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image'
        ]);

        $book = Book::where('slug', $slug)->firstOrFail();
        $data = $request->only(['title', 'author', 'publisher', 'year', 'stock', 'category_id']);
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            if ($book->image && Storage::exists('public/' . $book->image)) {
                Storage::delete('public/' . $book->image);
            }

            $data['image'] = $request->file('image')->store('books', 'public');
        }
        $book->update($data);

        return redirect()->route('admin.book.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        if ($book->image && Storage::exists($book->image)) {
            Storage::delete($book->image);
        }

        $book->delete();
        return redirect()->route('admin.book.index')->with('deleted', 'Buku berhasil dihapus');
    }

    // Untuk User
    public function userIndex(Request $request)
    {
        $search = $request->input('search');
        $books = Book::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('author', 'LIKE', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->simplePaginate(5);


        return view('user.books.index', compact('books', 'search'));
    }
}
