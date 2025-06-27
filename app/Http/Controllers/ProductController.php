<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use App\Models\Category;
use App\Enums\TargetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function product($id)
    {
        $product = Product::findOrFail($id);

        $comments = Comment::with(['user', 'replies' => function ($query) {
            $query->with('user');
        }])
            ->where('target_type', TargetType::Product)
            ->where('target_id', $product->product_id)
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->get();

        $related = Product::where('product_id', '!=', $id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('pages.products', compact('product', 'comments', 'related'));
    }

    // Autentikasi Sebelum Komentar dan Menyimpan Komentar
    public function comments(Request $request, $id)
    {
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Anda harus login untuk mengirim komentar.');
    }

    $request->validate([
        'content' => 'required|string'
    ]);

    $product = Product::findOrFail($id);

    $product->comments()->create([
        'content' => $request->content,
        'user_id' => auth()->id(),
        'parent_id' => null,
    ]);

    return back()->with('success', 'Komentar berhasil dikirim!');
    }

    // Autentikasi Sebelum Komentar dan Menyimpan Komentar
    public function replies(Request $request, $id)
    {
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Anda harus login untuk mengirim komentar.');
    }

    $request->validate([
        'content' => 'required|string',
        'parent_id' => 'nullable|integer|exists:comments,comment_id'
    ]);

    $product = Product::findOrFail($id);

    $product->comments()->create([
        'content' => $request->content,
        'user_id' => auth()->id(),
        'parent_id' => $request->parent_id
    ]);


        try {
            return back()->with('success', 'Balasan berhasil dikirim!');
        } catch (\Exception $e) {
            \Log::error("Reply creation failed: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    // Halaman list produk
    public function list()
    {
        return view('pages.list_product');
    }
}
