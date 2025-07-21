<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAboutRequest;
use App\Models\CompanyAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CompanyAboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CompanyAbout::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%");
        }

        $data = $query->paginate(5);

        $addFields = [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Name',
                'placeholder' => 'Enter name',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'thumbnail',
                'label' => 'Select Thumbnail Image',
                'required' => true
            ],
            [
                'type' => 'select', 
                'name' => 'type', 
                'label' => 'Select Type',
                'options' => [
                    1 => 'Vission',
                    2 => 'Mission',
                ], 
                'placeholder' => 'Select Type',
                'required' => true
            ],
            [
                'type' => 'keypoints',
                'name' => 'keypoints',
                'label' => 'Keypoints',
                'count' => 3,
                'required' => false
            ]
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
                'type' => 'file',
                'name' => 'thumbnail',
                'label' => 'Select Thumbnail Image',
                'required' => false
            ],
            [
                'type' => 'select', 
                'name' => 'type', 
                'label' => 'Select Type',
                'options' => [
                    1 => 'Vission',
                    2 => 'Mission',
                ], 
                'placeholder' => 'Select Type',
                'required' => true
            ],
            [
                'type' => 'keypoints',
                'name' => 'keypoints',
                'label' => 'Keypoints',
                'count' => 3,
                'required' => false
            ]
        ];

        return view('admin.abouts.index', compact('addFields', 'editFields', 'data'));
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
    public function store(StoreAboutRequest $request)
    {
        //         // Validasi input
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        //     'type' => 'required|string'
        // ]);

        // // Jika validasi gagal, kembali ke halaman sebelumnya
        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        try {
            DB::beginTransaction();
            // Ambil input
            $data = $request->only(['name']);
            // Map type selection to string
            $typeMap = [1 => 'Vission', 2 => 'Mission'];
            $data['type'] = $typeMap[$request->input('type')] ?? $request->input('type');

            // Upload file gambar jika ada
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('abouts', $filename, 'public');
                $data['thumbnail'] = $path;
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();

            // Simpan ke database
            $about = CompanyAbout::create($data);

            // Simpan keypoints jika ada
            $keypoints = array_filter($request->input('keypoints', []), function($k) {
                return trim($k) !== '';
            });
            foreach ($keypoints as $keypoint) {
                $about->keypoints()->create([
                    'keypoint' => $keypoint,
                    'created_by' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.abouts.index')
                ->with('success', 'Company About berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyAbout $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyAbout $about)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $about = CompanyAbout::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'type' => 'required|string'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            // Ambil input
            $data = $request->only(['name']);
            // Map type selection to string
            $typeMap = [1 => 'Vission', 2 => 'Mission'];
            $data['type'] = $typeMap[$request->input('type')] ?? $request->input('type');

            // Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($request->hasFile('thumbnail')) {
                if ($about->image_path && Storage::disk('public')->exists($about->image_path)) {
                    Storage::disk('public')->delete($about->image_path);
                }

                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('abouts', $filename, 'public');
                $data['image_path'] = $path;
            }
            
            // Update data
            $about->update($data);

            // Update keypoints
            if ($request->has('keypoints')) {
                // Hapus keypoints lama
                $about->keypoints()->delete();
                // Tambahkan keypoints baru
                $keypoints = array_filter($request->input('keypoints', []), function($k) {
                    return trim($k) !== '';
                });
                foreach ($keypoints as $keypoint) {
                    $about->keypoints()->create([
                        'keypoint' => $keypoint,
                        'created_by' => Auth::id(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.abouts.index')
                ->with('success', 'Company About berhasil di update!');
        } catch (\Exception $e) {
            DB::rollBack();
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
            $about = CompanyAbout::findOrFail($id);

            // Hapus file gambar jika ada
            if ($about->image_path && Storage::disk('public')->exists($about->image_path)) {
                Storage::disk('public')->delete($about->image_path);
            }

            $about->delete();

            return redirect()->route('admin.abouts.index')
                ->with('success', 'Company About berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
