<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Specification::with('subcategory.category');

        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('subcategory', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->has('subcategory_id') && $request->subcategory_id) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $specifications = $query->get();
        $categories = Category::all()->isEmpty() ? collect([]) : Category::all();
        $subcategories = Subcategory::all()->isEmpty() ? collect([]) : Subcategory::all();

        return view('admin.specifications.index', compact('specifications', 'categories', 'subcategories'));
    }

    // باقي الدوال (create, store, edit, update, destroy) زي ما كانوا
    public function create()
    {
        $subcategories = Subcategory::all();
        return view('admin.specifications.create', compact('subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $data = $request->only('title', 'subcategory_id', 'content');
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('specifications', 'public');
        }

        $specification = Specification::create($data);

        return response()->json([
            'message' => 'تم إضافة المواصفة بنجاح',
            'specification' => $specification->load('subcategory.category')
        ], 201);
    }

    public function edit(Specification $specification)
    {
        $subcategories = Subcategory::all();
        return view('admin.specifications.edit', compact('specification', 'subcategories'));
    }

    public function update(Request $request, Specification $specification)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $data = $request->only('title', 'subcategory_id', 'content');
        if ($request->hasFile('file')) {
            if ($specification->file_path) {
                Storage::disk('public')->delete($specification->file_path);
            }
            $data['file_path'] = $request->file('file')->store('specifications', 'public');
        }

        $specification->update($data);

        return response()->json([
            'message' => 'تم تعديل المواصفة بنجاح',
            'specification' => $specification->load('subcategory.category')
        ]);
    }

    public function destroy(Specification $specification)
    {
        if ($specification->file_path) {
            Storage::disk('public')->delete($specification->file_path);
        }
        $specification->delete();

        return response()->json(['message' => 'تم حذف المواصفة بنجاح']);
    }
    
    public function specificationsIndex(Request $request)
    {
        $query = Specification::with('subcategory.category');

        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->whereHas('subcategory', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->has('subcategory_id') && $request->subcategory_id) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        $specifications = $query->get();
        $categories = Category::all()->isEmpty() ? collect([]) : Category::all();
        $subcategories = Subcategory::all()->isEmpty() ? collect([]) : Subcategory::all();

        return view('specifications.index', compact('specifications', 'categories', 'subcategories'));
    }

    /**
     * عرض المواصفات التابعة لقسم فرعي معين
     */
    public function subcategory(Subcategory $subcategory)
    {
        if (!$subcategory) {
            abort(404, 'القسم الفرعي غير موجود');
        }

        $specifications = Specification::where('subcategory_id', $subcategory->id)
            ->with('subcategory.category')
            ->get();

        $categories = Category::all()->isEmpty() ? collect([]) : Category::all();

        return view('specifications.index', compact('specifications', 'categories', 'subcategory'));
    }

    /**
     * عرض المواصفات التابعة لقسم رئيسي معين
     */
    public function category(Category $category)
    {
        if (!$category) {
            abort(404, 'القسم الرئيسي غير موجود');
        }

        $specifications = Specification::whereHas('subcategory', function ($q) use ($category) {
            $q->where('category_id', $category->id);
        })->with('subcategory.category')->get();

        $categories = Category::all()->isEmpty() ? collect([]) : Category::all();

        return view('specifications.index', compact('specifications', 'categories', 'category'));
    }

    /**
     * عرض تفاصيل مواصفة معينة
     */
    public function show(Specification $specification)
    {
        if (!$specification) {
            abort(404, 'المواصفة غير موجودة');
        }

        $specification->load('subcategory.category');
        $categories = Category::all()->isEmpty() ? collect([]) : Category::all();

        return view('specification', compact('specification', 'categories'));
    }
}
