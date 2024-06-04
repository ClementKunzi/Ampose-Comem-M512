<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TagAccessibility;

class TagAccessibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tagAccessibilities = TagAccessibility::with('taxonomy')->get();
        $tagAccessibilities->makeHidden(['taxonomy_id', 'created_at', 'updated_at']);
        foreach ($tagAccessibilities as $tagAccessibilitie) {
            $tagAccessibilitie->taxonomy->makeHidden(['updated_at', 'created_at', 'id']);
        }
        return response()->json($tagAccessibilities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
