<?php

namespace App\Http\Controllers;

use App\Models\Showcase;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShowcaseRequest;
use App\Http\Requests\UpdateShowcaseRequest;
use Illuminate\Support\Facades\DB;

class ShowcaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $showcases = Showcase::orderByDesc('id')->paginate(10);
        return view('admin.showcases.index', compact('showcases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.showcases.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShowcaseRequest $request)
    {
        //
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $newShowcase = Showcase::create($validated);
        });
        return redirect()->route('admin.showcases.index')->with('success', 'Showcase created successfully.');
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
        return view('admin.showcases.edit', compact('showcase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShowcaseRequest $request, Showcase $showcase)
    {
        //
        DB::transaction(function () use ($request, $showcase) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $showcase->update($validated);
        });
        return redirect()->route('admin.showcases.index')->with('success', 'Showcase updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Showcase $showcase)
    {
        //
        DB::transaction(function () use ($showcase) {
            $showcase->delete();
        });
        return redirect()->route('admin.showcases.index')->with('success', 'Showcase deleted successfully.');
    }
}

