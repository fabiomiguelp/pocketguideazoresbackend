<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BudgetLevel;
use App\Models\Island;
use App\Models\Partner;
use App\Models\TripCategory;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::with(['island', 'budgetLevel', 'category']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('island') && $request->island !== 'all') {
            $query->where('island_id', $request->island);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('trip_category_id', $request->category);
        }

        $partners   = $query->orderBy('name')->paginate(15)->withQueryString();
        $islands    = Island::orderBy('name')->get();
        $categories = TripCategory::orderBy('name')->get();

        return view('admin.partners.index', compact('partners', 'islands', 'categories'));
    }

    public function create()
    {
        $islands      = Island::orderBy('name')->get();
        $budgetLevels = BudgetLevel::orderBy('min_budget')->get();
        $categories   = TripCategory::orderBy('name')->get();

        return view('admin.partners.create', compact('islands', 'budgetLevels', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'description'      => ['required', 'string', 'max:1000'],
            'island_id'        => ['required', 'integer', 'exists:islands,id'],
            'budget_level_id'  => ['required', 'integer', 'exists:budget_levels,id'],
            'trip_category_id' => ['required', 'integer', 'exists:trip_categories,id'],
            'price'            => ['required', 'numeric', 'min:0', 'max:99999'],
            'contact'          => ['required', 'string', 'max:255'],
            'link'             => ['nullable', 'string', 'max:500'],
        ]);

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    public function edit(Partner $partner)
    {
        $islands      = Island::orderBy('name')->get();
        $budgetLevels = BudgetLevel::orderBy('min_budget')->get();
        $categories   = TripCategory::orderBy('name')->get();

        return view('admin.partners.edit', compact('partner', 'islands', 'budgetLevels', 'categories'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'description'      => ['required', 'string', 'max:1000'],
            'island_id'        => ['required', 'integer', 'exists:islands,id'],
            'budget_level_id'  => ['required', 'integer', 'exists:budget_levels,id'],
            'trip_category_id' => ['required', 'integer', 'exists:trip_categories,id'],
            'price'            => ['required', 'numeric', 'min:0', 'max:99999'],
            'contact'          => ['required', 'string', 'max:255'],
            'link'             => ['nullable', 'string', 'max:500'],
        ]);

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}
