<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
public function index()
{
    $categories = Category::whereNull('parent_id')
        ->with('children')
        ->latest()
        ->get();

    return view('admin.categories.index', compact('categories'));
}



   public function create()
{
    $categories = Category::whereNull('parent_id')->get();
    return view('admin.categories.create', compact('categories'));
}
public function store(Request $request)
{
    $data = $request->validate([
        'name'      => ['required','string','max:255'],
        'parent_id' => ['nullable','exists:categories,id'],
    ]);

    Category::create($data);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category created');
}


   public function edit(Category $category)
{
    $categories = Category::whereNull('parent_id')
        ->where('id', '!=', $category->id)
        ->get();

    return view('admin.categories.edit', compact('category', 'categories'));
}


    public function update(Request $request, Category $category)
{
    $data = $request->validate([
        'name'      => ['required','string','max:255'],
        'parent_id' => ['nullable','exists:categories,id'],
    ]);

    $category->update($data);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Category updated');
}


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted');
    }
}
