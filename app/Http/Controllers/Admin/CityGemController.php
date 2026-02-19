<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityGem;
use App\Models\Island;
use Illuminate\Http\Request;

class CityGemController extends Controller
{
    public function index(Request $request)
    {
        $query = CityGem::with('city.island');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('island') && $request->island !== 'all') {
            $query->whereHas('city', fn ($q) => $q->where('island_id', $request->island));
        }

        $gems    = $query->orderBy('name')->paginate(15)->withQueryString();
        $islands = Island::orderBy('name')->get();

        return view('admin.city-gems.index', compact('gems', 'islands'));
    }

    public function create()
    {
        $islands = Island::with('cities')->orderBy('name')->get();
        return view('admin.city-gems.create', compact('islands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_id'     => ['required', 'integer', 'exists:cities,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'tip'         => ['nullable', 'string', 'max:500'],
        ]);

        CityGem::create($validated);

        return redirect()->route('admin.city-gems.index')
            ->with('success', 'Hidden gem created successfully.');
    }

    public function edit(CityGem $cityGem)
    {
        $islands = Island::with('cities')->orderBy('name')->get();
        return view('admin.city-gems.edit', compact('cityGem', 'islands'));
    }

    public function update(Request $request, CityGem $cityGem)
    {
        $validated = $request->validate([
            'city_id'     => ['required', 'integer', 'exists:cities,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'tip'         => ['nullable', 'string', 'max:500'],
        ]);

        $cityGem->update($validated);

        return redirect()->route('admin.city-gems.index')
            ->with('success', 'Hidden gem updated successfully.');
    }

    public function destroy(CityGem $cityGem)
    {
        $cityGem->delete();

        return redirect()->route('admin.city-gems.index')
            ->with('success', 'Hidden gem deleted successfully.');
    }
}
