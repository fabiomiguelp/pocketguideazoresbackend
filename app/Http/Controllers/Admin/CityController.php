<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Island;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = City::with('island');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('island') && $request->island !== 'all') {
            $query->where('island_id', $request->island);
        }

        $cities  = $query->orderBy('name')->paginate(15)->withQueryString();
        $islands = Island::orderBy('name')->get();

        return view('admin.cities.index', compact('cities', 'islands'));
    }

    public function create()
    {
        $islands = Island::orderBy('name')->get();
        return view('admin.cities.create', compact('islands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'island_id' => ['required', 'integer', 'exists:islands,id'],
        ]);

        City::create($validated);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City created successfully.');
    }

    public function edit(City $city)
    {
        $islands = Island::orderBy('name')->get();
        return view('admin.cities.edit', compact('city', 'islands'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'island_id' => ['required', 'integer', 'exists:islands,id'],
        ]);

        $city->update($validated);

        return redirect()->route('admin.cities.index')
            ->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')
            ->with('success', 'City deleted successfully.');
    }
}
