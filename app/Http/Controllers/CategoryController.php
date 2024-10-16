<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $categories = Category::withCount('books')
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->simplePaginate(10);

    return view('admin.categories.index', compact('categories', 'search'));
}


    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $category = $request->only(['name']);
        $category['slug'] = Str::slug($request->input('name'));

        Category::create($category);

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $category = Category::findOrFail($slug);
        $category['slug'] = Str::slug($request->input('name'));

        $category->update($request->only('name','slug'));

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $category = Category::findOrFail($slug);
        $category->delete();

        return redirect()->route('admin.category.index')->with('deleted', 'Kategori berhasil dihapus.');
    }
}
