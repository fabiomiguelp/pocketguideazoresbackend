<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Island;
use Illuminate\Http\JsonResponse;

class IslandController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'islands' => Island::all(),
        ]);
    }

    public function cities(Island $island): JsonResponse
    {
        return response()->json([
            'cities' => $island->cities,
        ]);
    }
}
