<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TripCategory;
use Illuminate\Http\JsonResponse;

class TripCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'categories' => TripCategory::all(),
        ]);
    }
}
