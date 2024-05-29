<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Else_;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itineraries = Itinerary::with(['user', 'image', 'tagCategorie.taxonomy', 'tagAccessibility.taxonomy'])->get();
        //$itineraries = Itinerary::with(['user', 'image', 'tagCategorie', 'tagAccessibility'])->get();
        $itineraries->makeHidden('created_at');

        foreach ($itineraries as $itinerary) {
            $itinerary->user->makeHidden(['id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added',  'created_at', 'updated_at']);
            $itinerary->image->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagCategorie->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagAccessibility->makeHidden(['id', 'created_at', 'updated_at']);
            //$itinerary->tagCategorie->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
            //$itinerary->tagAccessibility->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
        }
        return response()->json($itineraries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItineraryRequest $request)
    {

        /*$imageFile = $request->file('image');
        $imagePath = $imageFile->store('images', 'public');

        $image = Image::create(['path' => $imagePath]);

        try {
            $validatedData = $request->validated();
            $validatedData['image_id'] = $image->id;

            $itinerary = Itinerary::create($validatedData);

            return $this->sendSuccess($itinerary, 'Itinerary created successfully');
        } catch (\Exception $e) {
            // Supprime l'image si la validation échoue
            Storage::disk('public')->delete($imagePath);
            $image->delete();

            throw $e;
        }*/

        return $this->sendSuccess($request->validated(), 'Itinerary created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $itinerary = Itinerary::with(['user', 'image', 'tagCategorie.taxonomy', 'tagAccessibility.taxonomy'])->find($id);
        if ($itinerary) {
            $itinerary->makeHidden('created_at');
            $itinerary->user->makeHidden('id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added', 'created_at', 'updated_at');
            $itinerary->image->makeHidden('id', 'created_at', 'updated_at');
            $itinerary->tagCategorie->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagAccessibility->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagCategorie->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagAccessibility->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
            return response()->json($itinerary);
        } else {
            return response()->json(['error' => 'Itinerary not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItineraryRequest $request, string $id)
    {
        $itinerary = Itinerary::findOrfail($id);
        $validatedData = $request->validate();

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imagePath = $imageFile->store('images', 'public');

            if (!$imagePath) {
                return $this->sendError('Image upload failed');
            }

            $image = Image::create(['path' => $imagePath]);

            // Supprime l'ancienne image si la nouvelle image a été téléchargée
            Storage::disk('public')->delete($itinerary->image->path);
            $itinerary->image->delete();

            $validatedData['image_id'] = $image->id;
        }

        $updateSuccess = $itinerary->update($validatedData);

        if (!$updateSuccess) {
            return $this->sendError('Itinerary update failed');
        } else {
            return $this->sendSuccess($itinerary, 'Itinerary updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $itinerary = Itinerary::findOrfail($id);

        $deleteSuccess = $itinerary->delete();

        if (!$deleteSuccess) {
            return $this->sendError('Itinerary deletion failed');
        } else {
            return $this->sendSuccess([], 'Itinerary deleted successfully');
        }
    }
}
