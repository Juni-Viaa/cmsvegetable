<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class ListBlogController extends Controller
{
    public function list_blog(Request $request)
    {
        $query = Blog::query();

        // Load relasi category untuk menghindari N+1 problem
        $query->with('category');

        // Filter berdasarkan kategori (jika ada)
        if ($request->has('category') && is_array($request->category)) {
            // Ambil ID kategori berdasarkan nama kategori yang dipilih
            $categoryIds = Category::where('category_type', 'blog')
                ->whereIn('category_name', $request->category)
                ->pluck('category_id')
                ->toArray();

            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Sortir berdasarkan pilihan pengguna
        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'az') {
            $query->orderBy('title', 'asc');
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $blogs = $query->paginate(12)->withQueryString();

        // Ambil semua kategori dengan type 'blog' dari tabel categories
        $categories = Category::where('category_type', 'blog')
            ->orderBy('category_name', 'asc')
            ->get(['category_id', 'category_name']);

        return view('pages.list_blog', compact('blogs', 'categories'));
    }
}
