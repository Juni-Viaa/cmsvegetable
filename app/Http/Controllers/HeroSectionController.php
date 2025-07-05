<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
                'placeholder' => 'Enter achivement',
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

        $data = HeroSection::orderByDesc('hero_id')->paginate(10);
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
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'heading' => 'required|string|max:255',
            'subheading' => 'required|string|max:255',
            'achievement' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'path_video' => 'required|string|max:255'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['heading', 'subheading', 'achievement', 'path_video']);

            // Upload file gambar jika ada
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('banners', $filename, 'public');
                $data['image_path'] = $path;
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();

            // Simpan ke database
            HeroSection::create($data);

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
    public function update(Request $request, $id)
    {
        $hero = HeroSection::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'heading' => 'required|string|max:255',
            'subheading' => 'required|string|max:255',
            'achievement' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'path_video' => 'required|string|max:255'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

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

    /**
     * Mengambil data produk untuk kebutuhan AJAX (misal: untuk edit modal).
     */
    public function getHero($id)
    {
        try {
            $hero = HeroSection::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $hero
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hero Section not found'
            ], 404);
        }
    }
}
