<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all()->isEmpty() ? collect([]) : Subcategory::with('category')->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
        $subcategory = Subcategory::create($request->only('name', 'category_id'));
        return response()->json(['message' => 'تم إضافة القسم الفرعي بنجاح', 'subcategory' => $subcategory], 201);
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
        $subcategory->update($request->only('name', 'category_id'));
        return response()->json(['message' => 'تم تعديل القسم الفرعي بنجاح', 'subcategory' => $subcategory]);
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return response()->json(['message' => 'تم حذف القسم الفرعي بنجاح']);
    }
    
    public function subcategoriesIndex(Category $category)
    {
        if (!$category) {
            abort(404, 'القسم الرئيسي غير موجود');
        }

        $subcategories = Subcategory::where('category_id', $category->id)->get();
        $categories = Category::all()->isEmpty() ? collect([]) : Category::all();

        return view('subcategories.index', compact('subcategories', 'categories', 'category'));
    }
}