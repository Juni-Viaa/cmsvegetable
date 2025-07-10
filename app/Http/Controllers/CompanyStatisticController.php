<?php

namespace App\Http\Controllers;

use App\Models\CompanyStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyStatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = CompanyStatistic::query();

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
                'placeholder' => 'Enter statistic name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'goal',
                'label' => 'Goal',
                'placeholder' => 'Enter statistic goal',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'icon',
                'label' => 'Select Icon Image',
                'required' => true
            ],
        ];

        $editFields = [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Name',
                'placeholder' => 'Enter statistic name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'goal',
                'label' => 'Goal',
                'placeholder' => 'Enter statistic goal',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'icon',
                'label' => 'Select Icon Image',
                'required' => false
            ],
        ];

        $data = CompanyStatistic::orderByDesc('statistic_id')->paginate(10);
        return view('admin.statistics.index', compact('data', 'addFields', 'editFields'));
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
            'goal' => 'required|string|max:255',
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
            $data = $request->only(['name', 'goal']);

            // Upload file gambar jika ada
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('statistics', $filename, 'public'); // simpan ke folder public/products
                $data['icon'] = $path;
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();

            // Simpan ke database
            CompanyStatistic::create($data);

            return redirect()->route('admin.statistics.index')
                ->with('success', 'Company statistic berhasil ditambahkan!');
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
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $stat = CompanyStatistic::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'goal' => 'required|string|max:255',
            'icon' => 'false|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['name', 'goal']);

            // Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($request->hasFile('icon')) {
                if ($stat->image_path && Storage::disk('public')->exists($stat->image_path)) {
                    Storage::disk('public')->delete($stat->image_path);
                }

                $file = $request->file('icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('statistics', $filename, 'public');
                $data['icon'] = $path;
            }
            
            // Update data
            $stat->update($data);

            return redirect()->route('admin.statistics.index')
                ->with('success', 'Company statistic berhasil di update!');
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
            $stat = CompanyStatistic::findOrFail($id);

            // Hapus file gambar jika ada
            if ($stat->image_path && Storage::disk('public')->exists($stat->image_path)) {
                Storage::disk('public')->delete($stat->image_path);
            }

            $stat->delete();

            return redirect()->route('admin.statistics.index')
                ->with('success', 'Company statistic berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
