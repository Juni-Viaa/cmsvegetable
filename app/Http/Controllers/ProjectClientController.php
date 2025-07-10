<?php

namespace App\Http\Controllers;

use App\Models\ProjectClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = ProjectClient::query();

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
                'placeholder' => 'Enter client name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'occupation',
                'label' => 'Occupation',
                'placeholder' => 'Enter occupation',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'avatar',
                'label' => 'Select Avatar Image',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'logo',
                'label' => 'Select Logo Image',
                'required' => true
            ]
        ];

        $editFields = [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Name',
                'placeholder' => 'Enter client name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'occupation',
                'label' => 'Occupation',
                'placeholder' => 'Enter occupation',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'avatar',
                'label' => 'Select Avatar Image',
                'required' => false
            ],
            [
                'type' => 'file',
                'name' => 'logo',
                'label' => 'Select Logo Image',
                'required' => false
            ]
        ];

        $data = ProjectClient::orderByDesc('client_id')->paginate(10);
        return view('admin.clients.index', compact('addFields', 'editFields', 'data'));
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
            'occupation' => 'required|string|max:255',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['name', 'occupation']);

            // Upload file gambar jika ada
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('clients/avatar', $filename, 'public');
                $data['avatar'] = $path;
            }

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('clients/avatar', $filename, 'public');
                $data['logo'] = $path;
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();

            // Simpan ke database
            ProjectClient::create($data);

            return redirect()->route('admin.clients.index')
                ->with('success', 'Data Client berhasil ditambahkan!');
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
        $client = ProjectClient::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['name', 'occupation']);

            // Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($request->hasFile('avatar')) {
                if ($client->image_path && Storage::disk('public')->exists($client->image_path)) {
                    Storage::disk('public')->delete($client->image_path);
                }

                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('clients/avatar', $filename, 'public');
                $data['avatar'] = $path;
            }

            if ($request->hasFile('logo')) {
                if ($client->image_path && Storage::disk('public')->exists($client->image_path)) {
                    Storage::disk('public')->delete($client->image_path);
                }

                $file = $request->file('logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('clients/logo', $filename, 'public');
                $data['logo'] = $path;
            }
            
            // Update data
            $client->update($data);

            return redirect()->route('admin.clients.index')
                ->with('success', 'Data Client berhasil di update!');
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
            $client = ProjectClient::findOrFail($id);

            // Hapus file gambar jika ada
            if ($client->image_path && Storage::disk('public')->exists($client->image_path)) {
                Storage::disk('public')->delete($client->image_path);
            }

            $client->delete();

            return redirect()->route('admin.clients.index')
                ->with('success', 'Data Client berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
