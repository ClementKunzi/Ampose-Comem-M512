<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TagCategorie;
use Illuminate\Http\Request;

class TagCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tagCategories = TagCategorie::with('taxonomy')->get();
        $tagCategories->makeHidden(['taxonomy_id', 'created_at', 'updated_at']);
        foreach ($tagCategories as $tagCategorie) {
            $tagCategorie->taxonomy->makeHidden(['updated_at', 'created_at', 'id']);
        }
        return response()->json($tagCategories);
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
