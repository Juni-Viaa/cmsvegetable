<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListBlogController extends Controller
{
    public function list_blog(Request $request)
{
    // Ambil filter dari request
    $selectedCategories = $request->input('category', []); // array dari checkbox
    $sort = $request->input('sort', 'latest'); // default: latest

    // Query dasar blog
    $query = Blog::with('category');

    // Filter kategori jika ada
    if (!empty($selectedCategories)) {
        $query->whereHas('category', function ($q) use ($selectedCategories) {
            $q->whereIn(DB::raw('LOWER(category_name)'), array_map('strtolower', $selectedCategories));
        });
    }

    // Sortir
    if ($sort === 'az') {
        $query->orderBy('title', 'asc');
    } else {
        $query->orderBy('created_at', 'desc'); // default latest
    }

    $blogs = $query->get();

    // Ambil semua kategori bertipe 'blog' untuk filter
    $categories = Category::where('category_type', 'blog')->pluck('category_name');

    return view('pages.list_blog', compact('blogs', 'categories'));
}
}
