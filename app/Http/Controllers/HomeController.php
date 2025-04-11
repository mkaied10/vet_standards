<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Specification::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->get();
        return view('search', compact('results', 'query'));
    }
}