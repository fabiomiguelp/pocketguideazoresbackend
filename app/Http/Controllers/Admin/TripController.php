<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::with(['user', 'island', 'city', 'budgetLevel', 'categories']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('island') && $request->island !== 'all') {
            $query->where('island_id', $request->island);
        }

        $trips   = $query->latest()->paginate(15)->withQueryString();
        $islands = \App\Models\Island::orderBy('name')->get();

        return view('admin.trips.index', compact('trips', 'islands'));
    }

    public function show(Trip $trip)
    {
        $trip->load(['user', 'island', 'city', 'budgetLevel', 'categories']);
        return view('admin.trips.show', compact('trip'));
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip deleted successfully.');
    }
}
