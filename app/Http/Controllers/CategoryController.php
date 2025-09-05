<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()  { $categories = Category::orderBy('title')->paginate(10); return view('categories.index', compact('categories')); }
    public function create() { return view('categories.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        Category::create($data);
        return redirect()->route('categories.index')->with('success','Category created.');
    }

    public function edit(Category $category)   { return view('categories.edit', compact('category')); }
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $category->update($data);
        return redirect()->route('categories.index')->with('success','Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','Category deleted.');
    }
}
