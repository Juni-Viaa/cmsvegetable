<?php

namespace App\Http\Controllers;

use App\Models\Showcase;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShowcaseRequest;
use App\Http\Requests\UpdateShowcaseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShowcaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Showcase::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%$search%");
        }

        $data = $query->paginate(5);

        $addFields = [
            [
                'type' => 'text', 
                'name' => 'about', 
                'label' => 'About Name',
                'placeholder' => 'Enter about name',
                'required' => true
            ],
            [
                'type' => 'text', 
                'name' => 'tagline', 
                'label' => 'Tagline Name',
                'placeholder' => 'Enter Tagline name',
                'required' => true
            ],
            [
                'type' => 'text', 
                'name' => 'name', 
                'label' => 'Showcase Name',
                'placeholder' => 'Enter shocase name',
                'required' => true
            ],
            [
                'type' => 'file', 
                'name' => 'thumbnail', 
                'label' => 'Select Thumbnail Image',
                'required' => true
            ]
        ];

        $editFields = [
                        [
                'type' => 'text', 
                'name' => 'about', 
                'label' => 'About Name',
                'placeholder' => 'Enter about name',
                'required' => true
            ],
            [
                'type' => 'text', 
                'name' => 'tagline', 
                'label' => 'Tagline Name',
                'placeholder' => 'Enter Tagline name',
                'required' => true
            ],
            [
                'type' => 'text', 
                'name' => 'name', 
                'label' => 'Showcase Name',
                'placeholder' => 'Enter shocase name',
                'required' => true
            ],
            [
                'type' => 'file', 
                'name' => 'image', 
                'label' => 'Select Thumbnail Image',
                'required' => false
            ]
        ];

        return view('admin.showcases.index', compact('addFields', 'editFields', 'data'));
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
    public function store(StoreShowcaseRequest $request)
    {
        // Validasi input
        // $validator = Validator::make($request->all(), [
        //     'about' => 'required|string|max:255',
        //     'tagline' => 'required|string|max:255',
        //     'name' => 'required|string|max:255',
        //     'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        try {
            $data = $request->only(['about', 'tagline', 'name']);
            
            // Handle file upload
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('showcases', $filename, 'public');
                $data['thumbnail'] = $path;
            } else {
                $data['thumbnail'] = 'default-thumbnail.png'; // or handle as needed
            }

            $data['created_by'] = Auth::id();

            Showcase::create($data);

            return redirect()->route('admin.showcases.index')
                ->with('success', 'Showcase successfully added!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Showcase $showcase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Showcase $showcase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShowcaseRequest $request, $id)
    {
        // $showcase = Showcase::findOrFail($id);

        // Validasi input
        // $validator = Validator::make($request->all(), [
        //     'about' => 'required|string|max:255',
        //     'tagline' => 'required|string|max:255',
        //     'name' => 'required|string|max:255',
        //     'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        try {
            $data = $request->only(['title', 'description', 'category_id']);
            
            // Handle file upload
            if ($request->hasFile('thumbnail')) {
                // Hapus file lama jika ada
                if ($request->image_path && Storage::disk('public')->exists($request->image_path)) {
                    Storage::disk('public')->delete($request->image_path);
                }
                
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('showcases', $filename, 'public');
                $data['thumbnail'] = $path;
            }

            $request->update($data);

            return redirect()->route('admin.showcases.index')
                ->with('success', 'Showcase berhasil diupdate!');
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
            $showcase = Showcase::findOrFail($id);
            
            // Hapus file gambar jika ada
            if ($showcase->image_path && Storage::disk('public')->exists($showcase->image_path)) {
                Storage::disk('public')->delete($showcase->image_path);
            }
            
            $showcase->delete();

            return redirect()->route('admin.showcases.index')
                ->with('success', 'Showcase berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

