<?php

namespace App\Http\Controllers;

use App\Models\OurPrinciple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OurPrincipleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addFields = [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Name',
                'placeholder' => 'Enter name',
                'required' => true
            ],
            [
                'type' => 'textarea',
                'name' => 'subtitle',
                'label' => 'Subtitle',
                'placeholder' => 'Enter subtitle',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'thumbnail',
                'label' => 'Select Thumbnail',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'icon',
                'label' => 'Select Icon',
                'required' => true
            ],
        ];

        $editFields = [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Name',
                'placeholder' => 'Enter name',
                'required' => true
            ],
            [
                'type' => 'textarea',
                'name' => 'subtitle',
                'label' => 'Subtitle',
                'placeholder' => 'Enter subtitle',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'thumbnail',
                'label' => 'Select Thumbnail',
                'required' => false
            ],
            [
                'type' => 'file',
                'name' => 'icon',
                'label' => 'Select Icon',
                'required' => false
            ],
        ];

        $data = OurPrinciple::orderByDesc('principle_id')->paginate(10);
        return view('admin.principles.index', compact('addFields', 'editFields', 'data'));
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
            'name' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['name', 'subtitle']);

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('principles/thumbnail', $filename, 'public');
                $data['thumbnail'] = $path;
            }

            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('principles/icon', $filename, 'public');
                $data['icon'] = $path;
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();

            // Simpan ke database
            OurPrinciple::create($data);

            return redirect()->route('admin.principles.index')
                ->with('success', 'Principle berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $principle = OurPrinciple::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'icon' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['name', 'subtitle']);

            // Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($request->hasFile('thumbnail')) {
                if ($principle->thumbnail && Storage::disk('public')->exists($principle->thumbnail)) {
                    Storage::disk('public')->delete($principle->thumbnail);
                }

                $file = $request->file('thumbnail');
                $filename = time() . '_thumb_' . $file->getClientOriginalName();
                $path = $file->storeAs('principles/thumbnail', $filename, 'public');
                $data['thumbnail'] = $path;
            }

            if ($request->hasFile('icon')) {
                if ($principle->icon && Storage::disk('public')->exists($principle->icon)) {
                    Storage::disk('public')->delete($principle->icon);
                }

                $file = $request->file('icon');
                $filename = time() . '_icon_' . $file->getClientOriginalName();
                $path = $file->storeAs('principles/icon', $filename, 'public');
                $data['icon'] = $path;
            }

            // Update data
            $principle->update($data);

            return redirect()->route('admin.principles.index')
                ->with('success', 'Principle berhasil di update!');
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
            $principle = OurPrinciple::findOrFail($id);

                // Hapus thumbnail jika ada
            if ($principle->thumbnail && Storage::disk('public')->exists($principle->thumbnail)) {
                Storage::disk('public')->delete($principle->thumbnail);
            }

            // Hapus icon jika ada
            if ($principle->icon && Storage::disk('public')->exists($principle->icon)) {
                Storage::disk('public')->delete($principle->icon);
            }

            $principle->delete();

            return redirect()->route('admin.principles.index')
                ->with('success', 'Principle berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
