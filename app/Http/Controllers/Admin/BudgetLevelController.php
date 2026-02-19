<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BudgetLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BudgetLevelController extends Controller
{
    public function index()
    {
        $budgetLevels = BudgetLevel::orderBy('min_budget')->paginate(15);

        return view('admin.budget-levels.index', compact('budgetLevels'));
    }

    public function create()
    {
        return view('admin.budget-levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'min_budget' => ['required', 'integer', 'min:0'],
            'max_budget' => ['nullable', 'integer', 'min:0', 'gt:min_budget'],
        ]);

        BudgetLevel::create([
            'name'       => $validated['name'],
            'slug'       => Str::slug($validated['name']),
            'min_budget' => $validated['min_budget'],
            'max_budget' => $validated['max_budget'] ?? null,
        ]);

        return redirect()->route('admin.budget-levels.index')
            ->with('success', 'Budget level created successfully.');
    }

    public function edit(BudgetLevel $budgetLevel)
    {
        return view('admin.budget-levels.edit', compact('budgetLevel'));
    }

    public function update(Request $request, BudgetLevel $budgetLevel)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'min_budget' => ['required', 'integer', 'min:0'],
            'max_budget' => ['nullable', 'integer', 'min:0', 'gt:min_budget'],
        ]);

        $budgetLevel->update([
            'name'       => $validated['name'],
            'slug'       => Str::slug($validated['name']),
            'min_budget' => $validated['min_budget'],
            'max_budget' => $validated['max_budget'] ?? null,
        ]);

        return redirect()->route('admin.budget-levels.index')
            ->with('success', 'Budget level updated successfully.');
    }

    public function destroy(BudgetLevel $budgetLevel)
    {
        if ($budgetLevel->trips()->exists()) {
            return redirect()->route('admin.budget-levels.index')
                ->with('error', 'Cannot delete budget level with existing trips.');
        }

        $budgetLevel->delete();

        return redirect()->route('admin.budget-levels.index')
            ->with('success', 'Budget level deleted successfully.');
    }
}
