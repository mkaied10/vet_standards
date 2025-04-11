<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Specification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Categories
    public function indexCategories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'تم إضافة القسم');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'تم تعديل القسم');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'تم حذف القسم');
    }

    // Subcategories
    public function indexSubcategories()
    {
        $subcategories = Subcategory::with('category')->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function createSubcategory()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        Subcategory::create($data);
        return redirect()->route('admin.subcategories.index')->with('success', 'تم إضافة القسم الفرعي');
    }

    public function editSubcategory(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function updateSubcategory(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $subcategory->update($data);
        return redirect()->route('admin.subcategories.index')->with('success', 'تم تعديل القسم الفرعي');
    }

    public function destroySubcategory(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'تم حذف القسم الفرعي');
    }

    // Specifications
    public function indexSpecifications()
    {
        $specifications = Specification::with('subcategory')->get();
        return view('admin.specifications.index', compact('specifications'));
    }

    public function createSpecification()
    {
        $subcategories = Subcategory::all();
        return view('admin.specifications.create', compact('subcategories'));
    }

    public function storeSpecification(Request $request)
    {
        $request->validate([
            'subcategory_id' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file_path' => 'nullable|file|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('files', 'public');
        }

        Specification::create($data);
        return redirect()->route('admin.specifications.index')->with('success', 'تم إضافة المواصفة');
    }

    public function editSpecification(Specification $specification)
    {
        $subcategories = Subcategory::all();
        return view('admin.specifications.edit', compact('specification', 'subcategories'));
    }

    public function updateSpecification(Request $request, Specification $specification)
    {
        $request->validate([
            'subcategory_id' => 'required|exists:sub_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file_path' => 'nullable|file|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('files', 'public');
        }

        $specification->update($data);
        return redirect()->route('admin.specifications.index')->with('success', 'تم تعديل المواصفة');
    }

    public function destroySpecification(Specification $specification)
    {
        $specification->delete();
        return redirect()->route('admin.specifications.index')->with('success', 'تم حذف المواصفة');
    }
}