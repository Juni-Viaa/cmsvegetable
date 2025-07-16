<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminProductController extends Controller
{
    /**
     * Menampilkan daftar produk dalam halaman admin dengan pagination dan pencarian.
     */
    public function index(Request $request)
    {
        // Query awal untuk memilih kolom dari tabel products
        $query = Product::query();

        // Jika ada parameter pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('product_name', 'like', "%$search%");
        }

        $data = $query->paginate(5);

        // Ambil daftar kategori dengan tipe 'Product'
        $category = Category::where('category_type', 'Product')
                ->pluck('category_name', 'category_id')
                ->toArray();

        // Field untuk form tambah produk
        $addFields = [
            [
                'type' => 'text',
                'name' => 'product_name',
                'label' => 'Product Name',
                'placeholder' => 'Enter product name',
                'required' => true
            ],
            [
                'type' => 'textarea',
                'name' => 'description',
                'label' => 'Description',
                'placeholder' => 'Enter product description',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'image',
                'label' => 'Select Image',
                'required' => true
            ],
            [
                'type' => 'select',
                'name' => 'category_id',
                'label' => 'Category',
                'options' => $category,
                'placeholder' => 'Select category',
                'required' => true
            ],
        ];

        // Field untuk form edit produk
        $editFields = [
            [
                'type' => 'text',
                'name' => 'product_name',
                'label' => 'Product Name',
                'placeholder' => 'Enter product name',
                'required' => true
            ],
            [
                'type' => 'textarea',
                'name' => 'description',
                'label' => 'Description',
                'placeholder' => 'Enter product description',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'image',
                'label' => 'Select New Image',
                'required' => false
            ],
            [
                'type' => 'select',
                'name' => 'category_id',
                'label' => 'Category',
                'options' => $category,
                'placeholder' => 'Select category',
                'required' => true
            ],
        ];

        // Kirim data ke view
        return view('admin.products.index', compact('data', 'addFields', 'editFields'));
    }

    /**
     * Menampilkan form untuk menambahkan produk (tidak digunakan di implementasi ini).
     */
    public function create()
    {
        //
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['product_name', 'description', 'category_id']);

            // Upload file gambar jika ada
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products', $filename, 'public');
                $data['image_path'] = $path;
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();

            // Simpan ke database
            Product::create($data);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan detail produk tertentu (tidak digunakan di implementasi ini).
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Memperbarui data produk yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['product_name', 'description', 'category_id']);

            // Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($request->hasFile('image')) {
                if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                    Storage::disk('public')->delete($product->image_path);
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products', $filename, 'public');
                $data['image_path'] = $path;
            }

            // Update data
            $product->update($data);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Hapus file gambar jika ada
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
