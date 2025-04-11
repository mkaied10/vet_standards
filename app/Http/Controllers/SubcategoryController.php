<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Category $category)
    {
        $subcategories = $category->subcategories;
        return view('subcategories.index', compact('category', 'subcategories'));
    }
}