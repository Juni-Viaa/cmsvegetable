<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Category; // Tambahkan ini jika Gallery Anda berelasi dengan Category
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function gallery(Request $request)
    {
        $query = Gallery::query();

        // Load relasi category jika ada, untuk filtering dan tampilan
        $query->with('category');

        // Filter berdasarkan kategori (jika ada)
        if ($request->has('category') && is_array($request->category)) {
            // Asumsi $request->category berisi nama kategori (string)
            // Anda perlu mengambil ID kategori dari nama kategori tersebut
            $categoryIds = Category::whereIn('category_name', $request->category)->pluck('category_id')->toArray();
            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Sortir
        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'az') {
            $query->orderBy('title', 'asc'); // Sesuaikan dengan kolom yang ingin Anda sortir secara A-Z
        } else {
            // Default sort jika tidak ada parameter atau parameter tidak valid
            $query->orderBy('created_at', 'desc');
        }

        // Ambil data galeri setelah filter dan sortir
        $vegetables = $query->get(); // Gunakan get() karena Anda tidak menggunakan paginate di sini

        // Ambil kategori unik yang tersedia di semua galeri (untuk filter checklist)
        // Ini memastikan hanya kategori yang memiliki item galeri yang ditampilkan di filter
        $categories = Category::whereIn('category_id', Gallery::pluck('category_id')->unique())->pluck('category_name')->unique();

        return view('pages.gallery', compact('vegetables', 'categories'));
    }
}