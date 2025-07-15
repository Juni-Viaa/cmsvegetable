<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ListProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori untuk ditampilkan di filter
        $categories = Category::where('category_type', 'product')->get();

        // Query awal untuk produk
        $query = Product::with('category');

        // === Filter berdasarkan kategori (checkbox) ===
        if ($request->has('category')) {
            $selectedCategories = $request->input('category');
            if (is_array($selectedCategories)) {
                $query->whereIn('category_id', $selectedCategories);
            }
        }

        // === Sort berdasarkan input radio ===
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'az') {
                $query->orderBy('product_name', 'asc');
            } elseif ($sort === 'terbaru') {
                $query->orderBy('updated_at', 'desc');
            }
        } else {
            // Default sorting
            $query->orderBy('updated_at', 'desc');
        }

        // Ambil hasil query dan paginasi
        $products = $query->paginate(9)->appends($request->query());

        return view('pages.list_product', compact('products', 'categories'));
    }
}