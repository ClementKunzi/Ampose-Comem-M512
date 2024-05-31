<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use App\Models\Step;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Else_;
use Illuminate\Support\Facades\DB;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itineraries = Itinerary::with(['user', 'image', 'tagCategorie.taxonomy', 'tagAccessibility.taxonomy'])->get();
        $itineraries->makeHidden('created_at');

        foreach ($itineraries as $itinerary) {
            $itinerary->user->makeHidden(['id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added',  'created_at', 'updated_at']);
            $itinerary->image->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagCategorie->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagAccessibility->makeHidden(['id', 'created_at', 'updated_at']);
        }
        return response()->json($itineraries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItineraryRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();

            $imageFile = $request->file('image');
            $imagePath = $imageFile->store('images', 'public');

            $image = Image::create([
                'url' => $imagePath,
                'alt_attr' => $request->get('image_description'),
            ]);
            $validatedData['image_id'] = $image->id;

            $itinerary = Itinerary::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'type' => $validatedData['type'],
                'estimated_time' => $validatedData['estimated_time'],
                'difficulty' => $validatedData['difficulty'],
                'source' => $validatedData['source'],
                'pdf_url' => $validatedData['pdf_url'],
                'user_id' => auth()->user()->id,
                'image_id' => $image->id,
            ]);

            if (isset($validatedData['negative_drop'])) {
                $itinerary->negative_drop = $validatedData['negative_drop'];
            }
            if (isset($validatedData['length'])) {
                $itinerary->length = $validatedData['length'];
            }
            if (isset($validatedData['positive_drop'])) {
                $itinerary->positive_drop = $validatedData['positive_drop'];
            }

            $itinerary->save();

            if ($request->has('steps')) {
                foreach ($request->get('steps') as $index => $step) {
                    if ($request->hasFile("steps.$index.stepImage")) {
                        $imageFile = $request->file("steps.$index.stepImage");
                        $imagePath = $imageFile->store('images', 'public');

                        $stepImage = Image::create([
                            'url' => $imagePath,
                            'alt_attr' => $step['image_description'],
                        ]);
                    }

                    $newStep = Step::create([
                        'name' => $step['name'],
                        'description' => $step['description'],
                        'adress' => $step['address'],
                        'latitude' => $step['latitude'],
                        'longitude' => $step['longitude'],
                        'order' => $step['order'],
                        'itinerary_id' => $itinerary->id,
                        'external_link' => $step['external_url'] ?? null,
                    ]);
                    if (isset($stepImage)) {
                        $newStep->images()->attach($stepImage->id);
                    }
                }
            }



            DB::commit();
            $itinerary->load('steps');
            $itinerary->makeHidden('created_at', 'updated_at');
            $itinerary->user->makeHidden('id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added', 'created_at', 'updated_at');
            $itinerary->image->makeHidden('id', 'created_at', 'updated_at');
            $itinerary->steps->makeHidden('created_at', 'updated_at', 'itinerary_id');
            $itinerary->append('formatted_updated_at');
            $itinerary->steps->append('formatted_updated_at');

            $user = auth()->user();
            $user->number_path_added += 1;
            $user->save();
            return $this->sendSuccess($itinerary, 'Itinerary created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            $imagePath = str_replace('/storage/', '', $image->url);
            Storage::disk('public')->delete($imagePath);
            $image->delete();
            return $this->sendError('Error creating itinerary', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $itinerary = Itinerary::with(['user', 'image', 'tagCategorie', 'tagAccessibility'])->find($id);
        if ($itinerary) {
            $itinerary->makeHidden('created_at', 'user_id', 'image_id', 'tag_categorie_id', 'tag_accessibility_id', 'positive_drop', 'negative_drop', 'length', 'updated_at');
            $itinerary->user->makeHidden('id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added', 'created_at', 'updated_at');
            $itinerary->image->makeHidden('id', 'created_at', 'updated_at');
            $itinerary->tagCategorie->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagAccessibility->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->append('formatted_updated_at');
            $itinerary->step->makeHidden('created_at', 'updated_at', 'itinerary_id');
            return $this->sendSuccess($itinerary, 'Itinerary retrieved successfully');
        } else {
            return $this->sendError('Itinerary not found', 404);
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
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $itinerary = Itinerary::find($id);
        if ($itinerary) {
            // Delete all steps associated with the itinerary
            $steps = Step::where('itinerary_id', $itinerary->id)->get();

            foreach ($steps as $step) {
                // Detach and delete the images associated with the step
                foreach ($step->images as $image) {
                    $step->images()->detach($image->id);
                    $image->delete();
                }

                // Now it's safe to delete the step
                $step->delete();
            }

            // Store the image id before deleting the itinerary
            $imageId = $itinerary->image_id;

            $deleteSuccess = $itinerary->delete();

            if (!$deleteSuccess) {
                return $this->sendError('Itinerary deletion failed');
            } else {
                // Delete the image associated with the itinerary
                $image = Image::find($imageId);
                if ($image) {
                    $image->delete();
                }
                $user = auth()->user();
                $user->number_path_added -= 1;
                $user->save();
                return $this->sendSuccess([], 'Itinerary deleted successfully');
            }
        } else {
            return $this->sendError('Itinerary not found', 404);
        }
    }
}
