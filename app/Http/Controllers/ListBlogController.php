<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class ListBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        $categories = Category::where('category_type', 'blog')->get();

       // Filter berdasarkan kategori
        if ($request->has('category') && is_array($request->category)) {
            $query->whereIn('category_id', $request->category);
        }

        // Sortir
        if ($request->sort === 'terbaru') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'az') {
            $query->orderBy('title', 'asc');
        }

        // Pagination
        $blogs = $query->paginate(12)->withQueryString();

        $alpinejs = $blogs->map(function ($v) {
        return [
            'id' => $v->blog_id,
            'name' => $v->title,
            'description' => $v->content,
            'image' => asset('storage/' . $v->image_path),
            ];
        });

        return view('pages.list_blog', compact('categories', 'blogs', 'alpinejs'));
    }
}
