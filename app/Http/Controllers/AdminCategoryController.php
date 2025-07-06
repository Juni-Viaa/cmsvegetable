<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = [
            'category_name' => 'Category Name',
            'category_type' => 'Category Type',
        ];
        $query = Category::select(array_merge(array_keys($columns), ['category_id']));

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%");
        }

        $data = $query->paginate(10);

        $addFields = [
            [
                'type' => 'text', 
                'name' => 'category_name', 
                'label' => 'Category Name',
                'placeholder' => 'Enter category name',
                'required' => true
            ],
            [
                'type' => 'select', 
                'name' => 'category_type', 
                'label' => 'Category',
                'options' => [
                    1 => 'Product',
                    2 => 'Blog',
                    3 => 'Gallery',
                ], 
                'placeholder' => 'Select Category Type',
                'required' => true
            ],
        ];

        $editFields = [
            [
                'type' => 'text', 
                'name' => 'category_name', 
                'label' => 'Category Name',
                'placeholder' => 'Enter category name',
                'required' => true
            ],
            [
                'type' => 'select', 
                'name' => 'category_type', 
                'label' => 'Category',
                'options' => [
                    1 => 'Product',
                    2 => 'Blog',
                    3 => 'Gallery',
                ], 
                'placeholder' => 'Select Category Type',
                'required' => false
            ],
        ];

        return view('admin.categories.index', compact('data', 'columns', 'addFields', 'editFields'));
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
            'category_name' => 'required|string|max:255',
            'category_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->only(['category_name', 'category_type']);

        Category::create($data);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'category_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->only(['category_name', 'category_type']);

            $category->update($data);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category berhasil diupdate!');
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
            $category = Category::findOrFail($id);

            $category->delete();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get category data for AJAX (untuk modal edit)
     */
    public function getCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
    }
}
