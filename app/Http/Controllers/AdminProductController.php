<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = [
            'product_name' => 'Product Name',
            'description' => 'Description',
            'category_id' => 'Category',
            'image_path' => 'Image',
        ];

        $query = Product::select(array_merge(array_keys($columns), ['product_id']));

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%");
        }

        $data = $query->paginate(10);

        $category = Category::where('category_type', 'Product')
                ->pluck('category_name', 'category_id')
                ->toArray();

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

        return view('admin.admin_product', compact('data', 'columns', 'addFields', 'editFields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->only(['product_name', 'description', 'category_id']);
            
            // Handle file upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products', $filename, 'public');
                $data['image_path'] = $path;
            }

            $data['created_by'] = Auth::id();

            Product::create($data);

            return redirect()->route('product.index')
                ->with('success', 'Product berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $category = Category::where('category_type', 'Product')->pluck('category_name', 'category_id')->toArray();
        return view('admin.admin_product.edit', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
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
            $data = $request->only(['product_name', 'description', 'category_id']);
            
            // Handle file upload
            if ($request->hasFile('image')) {
                // Hapus file lama jika ada
                if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                    Storage::disk('public')->delete($product->image_path);
                }
                
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('products', $filename, 'public');
                $data['image_path'] = $path;
            }

            $product->update($data);

            return redirect()->route('product.index')
                ->with('success', 'Product berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
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

            return redirect()->route('product.index')
                ->with('success', 'Product berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get product data for AJAX (untuk modal edit)
     */
    public function getProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    }
}