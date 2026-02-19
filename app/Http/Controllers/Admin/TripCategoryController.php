<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TripCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = TripCategory::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.trip-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.trip-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
        ]);

        TripCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
        ]);

        return redirect()->route('admin.trip-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(TripCategory $tripCategory)
    {
        return view('admin.trip-categories.edit', compact('tripCategory'));
    }

    public function update(Request $request, TripCategory $tripCategory)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
        ]);

        $tripCategory->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
        ]);

        return redirect()->route('admin.trip-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(TripCategory $tripCategory)
    {
        $tripCategory->delete();

        return redirect()->route('admin.trip-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
