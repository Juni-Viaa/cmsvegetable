<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ListProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        $categories = Category::where('category_type', 'product')->get();

        // Filter berdasarkan kategori (jika ada)
        if ($request->has('category') && is_array($request->category)) {
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && is_array($request->category)) {
            $query->whereIn('category_id', $request->category);
        }

        // Sortir
        if ($request->sort === 'terbaru') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'az') {
            $query->orderBy('product_name', 'asc');
        }

        // ✅ Pagination ditambahkan di sini (tanpa konfigurasi)
        $vegetables = $query->paginate(12)->withQueryString();  

        return view('pages.list_product', compact('categories', 'vegetables'));
    }
}
