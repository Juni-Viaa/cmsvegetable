<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addFields = [
            [
                'type' => 'file',
                'name' => 'thumbnail',
                'label' => 'Select Thumbnail Image',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'message',
                'label' => 'Message',
                'placeholder' => 'Enter testimonial message',
                'required' => true
            ]
        ];

        $editFields = [
            [
                'type' => 'file',
                'name' => 'thumbnail',
                'label' => 'Select Thumbnail Image',
                'required' => false
            ],
            [
                'type' => 'text',
                'name' => 'message',
                'label' => 'Message',
                'placeholder' => 'Enter testimonial message',
                'required' => true
            ]
        ];

        $data = Testimonial::orderByDesc('testimonial_id')->paginate(10);
        return view('admin.testimonials.index', compact('addFields', 'editFields', 'data'));
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
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'message' => 'required|string|max:255'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['message']);

            // Upload file gambar jika ada
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('testimonials', $filename, 'public'); // simpan ke folder public/products
                $data['thumbnail'] = $path;
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();

            // Simpan ke database
            Testimonial::create($data);

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'message' => 'required|string|max:255',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['message']);

            // Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($request->hasFile('thumbnail')) {
                if ($hero->image_path && Storage::disk('public')->exists($testimonial->image_path)) {
                    Storage::disk('public')->delete($testimonial->image_path);
                }

                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('testimonials', $filename, 'public');
                $data['image_path'] = $path;
            }
            
            // Update data
            $testimonial->update($data);

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial berhasil di update!');
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
            $testimonial = Testimonial::findOrFail($id);

            // Hapus file gambar jika ada
            if ($testimonial->image_path && Storage::disk('public')->exists($testimonial->image_path)) {
                Storage::disk('public')->delete($testimonial->image_path);
            }

            $testimonial->delete();

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
