<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product($id)
    {
        $product = Product::findOrFail($id);

        $comments = Comment::where('target_type', 'product')
                    ->where('product_id', $id)
                    ->whereNull('parent_id') // hanya komentar utama
                    ->orderByDesc('created_at')
                    ->with('replies')
                    ->get();

        $related = Product::where('product_id', '!=', $id)
                    ->inRandomOrder()
                    ->take(3)
                    ->get();

        return view('pages.products', compact('product', 'comments', 'related'));
    }

    // Menyimpan komentar
    public function submitComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|max:500',
        ]);

        Comment::create([
            'comment' => $request->comment,
            'user_id' => 0, // Tanpa login, kita set ke 0
            'target_type' => 'product',
            'product_id' => $id,
            'parent_id' => null,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }
    //Halaman List Product 
    public function list()
    {
        return view('pages.list_product');
    }
}
