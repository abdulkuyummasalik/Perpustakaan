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
    public function index()
    {
        $books = Book::with('category')->paginate(10);
        return view('admin.books.index', compact('books'));
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
        return redirect()->route('admin.book.index')->with('success', 'Buku berhasil dihapus');
    }




    public function search(Request $request)
    {
        $keyword = $request->input('search');

        $books = Book::where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('author', 'LIKE', "%{$keyword}%")
            ->orWhere('publisher', 'LIKE', "%{$keyword}%")
            ->orWhere('year', 'LIKE', "%{$keyword}%")
            ->orWhere('stock', 'LIKE', "%{$keyword}%")
            ->orWhereHas('category', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->paginate(10);

        return view('admin.books.index', ['books' => $books, 'search' => $keyword]);
    }

    // Untuk User
    public function userIndex()
    {
        $books = Book::with('category')->get();
        return view('user.books.index', compact('books'));
    }
}
