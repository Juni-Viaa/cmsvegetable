<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatisticRequest;
use App\Http\Requests\UpdateStatisticRequest;
use App\Models\CompanyStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CompanyStatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $statistics = CompanyStatistic::orderByDesc('id')->paginate(10);
        return view('landingpage.statistics.index', compact('statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('landingpage.statistics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatisticRequest $request)
    {
        // Insert kepada database pada table tertentu (company_statistics)
        // Closure-Based Transaction

        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons', 'public');
                $validated['icon'] = $iconPath;
            }
        
            $newDataRecord = CompanyStatistic::create($validated);

        });

        // Redirect or return response
        return redirect()->route('landingpage.statistics.index')->with('success', 'Statistic created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyStatistic $companyStatistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyStatistic $statistic)
    {
        //
        return view('landingpage.statistics.edit', compact('statistic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatisticRequest $request, CompanyStatistic $statistic)
    {
        // Insert kepada database pada table tertentu (company_statistics)
        // Closure-Based Transaction

        DB::transaction(function () use ($request, $statistic) {
            $validated = $request->validated();

            if($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons', 'public');
                $validated['icon'] = $iconPath;
            }

            $statistic->update($validated);

        });

        // Redirect or return response
        return redirect()->route('landingpage.statistics.index')->with('success', 'Statistic updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyStatistic $statistic)
    {
        //
        DB::transaction(function () use ($statistic) {
            $statistic->delete();
        });
        return redirect()->route('landingpage.statistics.index')->with('success', 'Statistic deleted successfully.');
    }
}
