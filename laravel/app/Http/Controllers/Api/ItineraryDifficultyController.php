<?php

namespace App\Http\Controllers\API;

use App\Enums\DifficultyEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItineraryDifficultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(DifficultyEnum::toArray());
    }
}
