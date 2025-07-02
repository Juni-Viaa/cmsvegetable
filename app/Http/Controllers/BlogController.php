<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Category;
use App\Enums\TargetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function blog($id)
    {
        $blog = Blog::findOrFail($id);

        $comments = Comment::with(['user', 'replies' => function ($query) {
            $query->with('user');
        }])
            ->where('target_type', TargetType::Blog)
            ->where('target_id', $blog->blog_id)
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->get();

        $related = Blog::where('blog_id', '!=', $id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('pages.blogs', compact('blog', 'comments', 'related'));
    }

    public function list()
    {
    $blog = Blog::latest()->paginate(6); // atau ->get() jika tidak ingin pagination
    return view('pages.list_blog', compact('blog'));
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

    $blog = Blog::findOrFail($id);

    $blog->comments()->create([
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

    $blog = Blog::findOrFail($id);

    $blog->comments()->create([
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
}
