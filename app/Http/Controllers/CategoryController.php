<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category = Category::create($request->only('name'));
        return response()->json(['message' => 'تم إضافة القسم بنجاح', 'category' => $category], 201);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update($request->only('name'));
        return response()->json(['message' => 'تم تعديل القسم بنجاح', 'category' => $category]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'تم حذف القسم بنجاح']);
    }
    public function categoriesIndex()
    {
        $categories = Category::all()->isEmpty() ? collect([]) : Category::all();
        return view('categories.index', compact('categories'));
    }
}