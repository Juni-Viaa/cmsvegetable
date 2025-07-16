<?php

namespace App\Http\Controllers;

use App\Models\OurTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OurTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OurTeam::query();

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
                'placeholder' => 'Enter team name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'occupation',
                'label' => 'Occupation',
                'placeholder' => 'Enter team occupation',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'location',
                'label' => 'Location',
                'placeholder' => 'Enter team location',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'avatar',
                'label' => 'Select Avatar Image',
                'required' => true
            ]
        ];

        $editFields = [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Name',
                'placeholder' => 'Enter team name',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'occupation',
                'label' => 'Occupation',
                'placeholder' => 'Enter team occupation',
                'required' => true
            ],
            [
                'type' => 'text',
                'name' => 'location',
                'label' => 'Location',
                'placeholder' => 'Enter team location',
                'required' => true
            ],
            [
                'type' => 'file',
                'name' => 'avatar',
                'label' => 'Select Avatar Image',
                'required' => false
            ]
        ];

        return view('admin.teams.index', compact('addFields', 'editFields', 'data'));
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
            'location' => 'required|string|max:255',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['name', 'occupation', 'location']);

            // Upload file gambar jika ada
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('teams', $filename, 'public');
                $data['avatar'] = $path;
            }

            // Tambahkan id user yang membuat
            $data['created_by'] = Auth::id();

            // Simpan ke database
            OurTeam::create($data);

            return redirect()->route('admin.teams.index')
                ->with('success', 'Team Member berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OurTeam $ourTeam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OurTeam $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $team = OurTeam::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil input
            $data = $request->only(['name', 'occupation', 'location']);

            // Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($request->hasFile('avatar')) {
                if ($team->image_path && Storage::disk('public')->exists($team->image_path)) {
                    Storage::disk('public')->delete($team->image_path);
                }

                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('teams', $filename, 'public');
                $data['avatar'] = $path;
            }
            
            // Update data
            $team->update($data);

            return redirect()->route('admin.teams.index')
                ->with('success', 'Team Member berhasil di update!');
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
            $team = OurTeam::findOrFail($id);

            // Hapus file gambar jika ada
            if ($team->image_path && Storage::disk('public')->exists($team->image_path)) {
                Storage::disk('public')->delete($team->image_path);
            }

            $team->delete();

            return redirect()->route('admin.teams.index')
                ->with('success', 'Team Member berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
