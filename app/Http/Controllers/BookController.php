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
            })
            ->simplePaginate(5);

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

        $book = new Book();
        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->year = $request->input('year');
        $book->stock = $request->input('stock');
        $book->category_id = $request->input('category_id');

        $book->slug = Str::slug($request->input('title'));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $book->image = $imagePath;
        }

        $book->save();

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

        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->year = $request->input('year');
        $book->stock = $request->input('stock');
        $book->category_id = $request->input('category_id');

        if ($request->hasFile('image')) {
            if ($book->image && Storage::exists('public/' . $book->image)) {
                Storage::delete('public/' . $book->image);
            }

            $imagePath = $request->file('image')->store('books', 'public');
            $book->image = $imagePath;
        }

        $book->save();
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
            ->simplePaginate(5);


        return view('user.books.index', compact('books', 'search'));
    }
}
