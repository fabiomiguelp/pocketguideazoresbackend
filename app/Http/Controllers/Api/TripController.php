<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Trip;
use App\Services\ItineraryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
{
    public function __construct(
        private ItineraryService $itineraryService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = $request->user()->isAdmin()
            ? Trip::with(['island', 'city', 'budgetLevel', 'categories', 'user'])
            : $request->user()->trips()->with(['island', 'city', 'budgetLevel', 'categories']);

        $trips = $query->latest()->get();

        return response()->json([
            'trips' => $trips,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'island_id'       => ['required', 'integer', 'exists:islands,id'],
            'category_ids'    => ['required', 'array', 'min:1'],
            'category_ids.*'  => ['integer', 'exists:trip_categories,id'],
            'budget_level_id' => ['required', 'integer', 'exists:budget_levels,id'],
            'num_adults'      => ['required', 'integer', 'min:1', 'max:20'],
            'num_children'    => ['required', 'integer', 'min:0', 'max:20'],
            'duration_days'   => ['required', 'integer', 'min:1', 'max:30'],
            'has_car'         => ['required', 'boolean'],
            'city_id'         => ['required', 'integer', 'exists:cities,id'],
        ]);

        $cityBelongsToIsland = City::where('id', $validated['city_id'])
            ->where('island_id', $validated['island_id'])
            ->exists();

        if (!$cityBelongsToIsland) {
            return response()->json([
                'message' => 'The selected city does not belong to the selected island.',
                'errors'  => ['city_id' => ['The selected city does not belong to the selected island.']],
            ], 422);
        }

        $trip = $request->user()->trips()->create([
            'island_id'       => $validated['island_id'],
            'budget_level_id' => $validated['budget_level_id'],
            'city_id'         => $validated['city_id'],
            'num_adults'      => $validated['num_adults'],
            'num_children'    => $validated['num_children'],
            'duration_days'   => $validated['duration_days'],
            'has_car'         => $validated['has_car'],
        ]);

        $trip->categories()->attach($validated['category_ids']);

        // Generate AI itinerary
        try {
            $itinerary = $this->itineraryService->generate($trip);
            $trip->update(['itinerary' => $itinerary]);
        } catch (\Throwable $e) {
            Log::error('ItineraryService failed', [
                'trip_id' => $trip->id,
                'error'   => $e->getMessage(),
            ]);
            // Trip is saved, itinerary will be null — can be retried later
        }

        $trip->load(['island', 'city', 'budgetLevel', 'categories']);

        return response()->json([
            'trip' => $trip,
        ], 201);
    }

    public function show(Request $request, Trip $trip): JsonResponse
    {
        if (!$request->user()->isAdmin() && $trip->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $trip->load(['island', 'city', 'budgetLevel', 'categories']);

        return response()->json([
            'trip' => $trip,
        ]);
    }

    public function destroy(Request $request, Trip $trip): JsonResponse
    {
        if (!$request->user()->isAdmin() && $trip->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $trip->delete();

        return response()->json([
            'message' => 'Trip deleted.',
        ]);
    }
}
