<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHeroSectionRequest;
use App\Http\Requests\UpdateHeroSectionRequest;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HeroSection::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('heading', 'like', "%$search%");
        }

        $data = $query->paginate(5);
        
        $addFields = [
            [
                'type' => 'text',
                'name' => 'heading',
                'label' => 'Heading',
                'placeholder' => 'Enter heading name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'subheading',
                'label' => 'Subheading',
                'placeholder' => 'Enter subheading name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'achievement',
                'label' => 'Achievement',
                'placeholder' => 'Enter achievement',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'image',
                'label' => 'Select Banner Image',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'path_video',
                'label' => 'Video path',
                'placeholder' => 'Enter video path',
                'required' => true
            ]
        ];

        $editFields = [
            [
                'type' => 'text',
                'name' => 'heading',
                'label' => 'Heading',
                'placeholder' => 'Enter heading name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'subheading',
                'label' => 'Subheading',
                'placeholder' => 'Enter subheading name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'achievement',
                'label' => 'Achievement',
                'placeholder' => 'Enter achievement',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'image',
                'label' => 'Select Banner Image',
                'required' => false
            ],
            [
                'type' => 'text',
                'name' => 'path_video',
                'label' => 'Video path',
                'placeholder' => 'Enter video path',
                'required' => true
            ]
        ];

        return view('admin.hero_sections.index', compact('data', 'addFields', 'editFields'));
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
    public function store(StoreHeroSectionRequest $request)
    {
        try {
            // Debug: Log the request data
            Log::info('Hero Section Store Request:', $request->all());
            
            // Ambil input
            $data = $request->only(['heading', 'subheading', 'achievement', 'path_video']);

            // Upload file gambar jika ada
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('banners', $filename, 'public');
                $data['image_path'] = $path;
                Log::info('File uploaded:', ['path' => $path]);
            } else {
                Log::warning('No image file found in request');
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();
            Log::info('Data to be saved:', $data);

            // Simpan ke database
            $heroSection = HeroSection::create($data);
            Log::info('Hero Section created:', ['id' => $heroSection->hero_id]);

            return redirect()->route('admin.hero_sections.index')
                ->with('success', 'Hero Section berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSection $heroSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSection $heroSection)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHeroSectionRequest $request, $id)
    {
        $hero = HeroSection::findOrFail($id);

        try {
            // Ambil input
            $data = $request->only(['heading', 'subheading', 'achievement', 'path_video']);

            // Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($request->hasFile('image')) {
                if ($hero->image_path && Storage::disk('public')->exists($hero->image_path)) {
                    Storage::disk('public')->delete($hero->image_path);
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('banners', $filename, 'public');
                $data['image_path'] = $path;
            }
            
            // Update data
            $hero->update($data);

            return redirect()->route('admin.hero_sections.index')
                ->with('success', 'Hero Section berhasil di update!');
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
            $hero = HeroSection::findOrFail($id);

            // Hapus file gambar jika ada
            if ($hero->image_path && Storage::disk('public')->exists($hero->image_path)) {
                Storage::disk('public')->delete($hero->image_path);
            }

            $hero->delete();

            return redirect()->route('admin.hero_sections.index')
                ->with('success', 'Hero Section berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
