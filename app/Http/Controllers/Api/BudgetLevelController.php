<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BudgetLevel;
use Illuminate\Http\JsonResponse;

class BudgetLevelController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'budget_levels' => BudgetLevel::all(),
        ]);
    }
}
