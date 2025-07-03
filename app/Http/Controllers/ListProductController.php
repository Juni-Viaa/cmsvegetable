<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ListProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        $categories = Category::where('category_type', 'product')->get();

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

        // Pagination
        $products = $query->paginate(12)->withQueryString();

        $alpinejs = $products->map(function ($v) {
        return [
            'id' => $v->product_id,
            'name' => $v->product_name,
            'description' => $v->description,
            'image' => asset('storage/' . $v->image_path),
            ];
        });

        return view('pages.list_product', compact('categories', 'products', 'alpinejs'));
    }
}
