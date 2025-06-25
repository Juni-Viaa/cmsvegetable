<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category; // Pastikan model Category sudah di-import
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
            // Asumsi $request->category berisi nama kategori (string)
            // Kita perlu mencari ID kategori berdasarkan nama yang diterima
            $categoryIds = Category::whereIn('category_name', $request->category)->pluck('category_id')->toArray();
            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Sortir
        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'az') {
            $query->orderBy('title', 'asc'); // Urutkan berdasarkan judul blog A-Z
        } else {
            // Default sort jika tidak ada parameter atau parameter tidak valid
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        // ✅ Pagination ditambahkan di sini (tanpa konfigurasi)
        $blogs = $query->paginate(12)->withQueryString();

        // Ambil semua kategori unik yang memiliki blog, untuk ditampilkan di filter
        // Menggunakan distinct() pada category_name dari relasi blog
        $categories = Blog::with('category')->get()
                        ->pluck('category.category_name')
                        ->filter()
                        ->unique()
                        ->values(); // Reset keys for clean iteration in blade

        return view('pages.list_blog', compact('blogs', 'categories'));
    }
}
