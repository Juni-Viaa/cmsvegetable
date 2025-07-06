<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = [
            'title' => 'Gallery Title',
            'description' => 'Description',
            'category_id' => 'Category',
            'image_path' => 'Image',
        ];

        $query = Gallery::select(array_merge(array_keys($columns), ['gallery_id']));

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%");
        }

        $data = $query->paginate(10);

        $category = Category::where('category_type', 'Gallery')
                ->pluck('category_name', 'category_id')
                ->toArray();
        
        $addFields = [
            [
                'type' => 'text', 
                'name' => 'title', 
                'label' => 'Gallery Name',
                'placeholder' => 'Enter gallery name',
                'required' => true
            ],
            [
                'type' => 'textarea', 
                'name' => 'description', 
                'label' => 'Description',
                'placeholder' => 'Enter gallery description',
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
                'name' => 'title', 
                'label' => 'Gallery Name',
                'placeholder' => 'Enter gallery name',
                'required' => true
            ],
            [
                'type' => 'textarea', 
                'name' => 'description', 
                'label' => 'Description',
                'placeholder' => 'Enter gallery description',
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

        return view('admin.galleries.index', compact('data', 'columns', 'addFields', 'editFields'));
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
            'title' => 'required|string|max:255',
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
            $data = $request->only(['title', 'description', 'category_id']);
            
            // Handle file upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('galleries', $filename, 'public');
                $data['image_path'] = $path;
            }

            $data['created_by'] = Auth::id();

            Gallery::create($data);

            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery berhasil ditambahkan!');
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
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
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
            $data = $request->only(['title', 'description', 'category_id']);
            
            // Handle file upload
            if ($request->hasFile('image')) {
                // Hapus file lama jika ada
                if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                    Storage::disk('public')->delete($gallery->image_path);
                }
                
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('galleries', $filename, 'public');
                $data['image_path'] = $path;
            }

            $gallery->update($data);

            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery berhasil diupdate!');
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
            $gallery = Gallery::findOrFail($id);
            
            // Hapus file gambar jika ada
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            
            $gallery->delete();

            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get gallery data for AJAX (untuk modal edit)
     */
    public function getGallery($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $gallery
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery not found'
            ], 404);
        }
    }
}
