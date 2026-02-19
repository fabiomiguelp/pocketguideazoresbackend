<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Island;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IslandController extends Controller
{
    public function index(Request $request)
    {
        $query = Island::withCount('cities');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $islands = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.islands.index', compact('islands'));
    }

    public function create()
    {
        return view('admin.islands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:500'],
        ]);

        Island::create([
            'name'  => $validated['name'],
            'slug'  => Str::slug($validated['name']),
            'image' => $validated['image'] ?? null,
        ]);

        return redirect()->route('admin.islands.index')
            ->with('success', 'Island created successfully.');
    }

    public function edit(Island $island)
    {
        $island->load('cities');
        return view('admin.islands.edit', compact('island'));
    }

    public function update(Request $request, Island $island)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:500'],
        ]);

        $island->update([
            'name'  => $validated['name'],
            'slug'  => Str::slug($validated['name']),
            'image' => $validated['image'] ?? null,
        ]);

        return redirect()->route('admin.islands.index')
            ->with('success', 'Island updated successfully.');
    }

    public function destroy(Island $island)
    {
        if ($island->trips()->exists()) {
            return redirect()->route('admin.islands.index')
                ->with('error', 'Cannot delete island with existing trips.');
        }

        $island->delete();

        return redirect()->route('admin.islands.index')
            ->with('success', 'Island deleted successfully.');
    }
}
