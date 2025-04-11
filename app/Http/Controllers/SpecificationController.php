<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecificationController extends Controller
{
    public function index()
    {
        $specifications = Specification::with('subcategory.category')->get();
        return view('admin.specifications.index', compact('specifications'));
    }

    public function create()
    {
        $subcategories = Subcategory::all();
        return view('admin.specifications.create', compact('subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
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
            'subcategory_id' => 'required|exists:subcategories,id',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only('title', 'subcategory_id', 'content');
        if ($request->hasFile('file')) {
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
}

