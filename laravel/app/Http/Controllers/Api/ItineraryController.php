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
use Illuminate\Support\Facades\Log;
use App\Models\TagCategorie;
use App\Models\TagAccessibility;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itineraries = Itinerary::with(['user', 'image', 'tagCategorie.taxonomy', 'tagAccessibility.taxonomy', 'steps'])->get();
        $itineraries->makeHidden('created_at', 'updated_at');

        $itineraries->transform(function ($itinerary) {
            $itinerary->makeHidden(['created_at', 'updated_at']);
            $itinerary->user->makeHidden(['id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added',  'created_at', 'updated_at']);
            $itinerary->image->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagCategorie->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->tagAccessibility->makeHidden(['id', 'created_at', 'updated_at']);
            $itinerary->append('formatted_updated_at');


            if ($itinerary->steps->isNotEmpty()) {
                $firstStep = $itinerary->steps->first();
                $itinerary->setAttribute('first_step_latitude', $firstStep->latitude);
                $itinerary->setAttribute('first_step_longitude', $firstStep->longitude);
            }

            unset($itinerary->steps);
            return $itinerary;
        });
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
                'alt_attr' => $request->input('image_description'),
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

            $tagCategories = TagCategorie::find($request->input('tagCategories'));
            $itinerary->tagCategorie()->attach($tagCategories);

            // Ajouter les tags d'accessibilité à l'itinéraire
            $tagAccessibilities = TagAccessibility::find($request->input('tagAccessibilities'));
            $itinerary->tagAccessibility()->attach($tagAccessibilities);

            // Update additional attributes if present in the validated data
            if (isset($validatedData['negative_drop'])) {
                $itinerary->negative_drop = $validatedData['negative_drop'];
            }
            if (isset($validatedData['length'])) {
                $itinerary->length = $validatedData['length'];
            }
            if (isset($validatedData['positive_drop'])) {
                $itinerary->positive_drop = $validatedData['positive_drop'];
            }

            // Save the itinerary
            $itinerary->save();

            // Process the steps if present in the request
            if ($request->has('steps')) {
                foreach ($request->input('steps') as $index => $step) {
                    // Handle step image if present
                    if ($request->hasFile("steps.$index.stepImage")) {
                        $imageFile = $request->file("steps.$index.stepImage");
                        $extension = $imageFile->getClientOriginalExtension();
                        $newFilename = time() . '_' . uniqid() . '.' . $extension;
                        $imagePath = $imageFile->storeAs('images', $newFilename, 'public');
                        $stepImage = Image::create([
                            'url' => $newFilename,
                            'alt_attr' => $step['image_description'],
                        ]);
                    }

                    // Create a new Step model
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

                    // Attach the step image if present
                    if (isset($stepImage)) {
                        $newStep->images()->attach($stepImage->id);
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            // Load related models and hide specific attributes
            $itinerary->load('steps', 'tagCategorie.taxonomy', 'tagAccessibility.taxonomy', 'user');
            $itinerary->makeHidden('created_at', 'user_id', 'image_id', 'tag_categorie_id', 'tag_accessibility_id', 'positive_drop', 'negative_drop', 'length', 'updated_at');
            $itinerary->user->makeHidden('id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added', 'created_at', 'updated_at');
            $itinerary->image->makeHidden('id', 'created_at', 'updated_at');
            $itinerary->tagCategorie->makeHidden(['created_at', 'updated_at', 'pivot', 'taxonomy_id']);
            foreach ($itinerary->tagCategorie as $tagCategorie) {
                $tagCategorie->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
            }
            $itinerary->tagAccessibility->makeHidden(['created_at', 'updated_at', 'pivot', 'taxonomy_id']);
            foreach ($itinerary->tagAccessibility as $tagAccessibility) {
                $tagAccessibility->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
            }
            $itinerary->append('formatted_updated_at');
            foreach ($itinerary->steps as $step) {
                $step->makeHidden(['created_at',  'itinerary_id', 'updated_at']);
                $step->append('formatted_updated_at');
            }

            // Update the number of paths added for the authenticated user
            $user = auth()->user();
            $user->number_path_added += 1;
            $user->save();

            // Return a success response with the created itinerary
            return $this->sendSuccess($itinerary, 'Itinerary created successfully');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error

            // Delete the uploaded image and its associated model
            $imagePath = str_replace('/storage/', '', $image->url);
            Storage::disk('public')->delete($imagePath);
            //$image->delete();

            // Return an error response
            return $this->sendError('Error creating itinerary', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        // Retrieve the itinerary with its related models
        $itinerary = Itinerary::with(['user', 'image', 'tagCategorie.taxonomy', 'tagAccessibility.taxonomy', 'steps.images',])->find($id);

        if ($itinerary) {
            // Hide specific attributes from the response
            $itinerary->makeHidden('created_at', 'user_id', 'image_id', 'tag_categorie_id', 'tag_accessibility_id', 'positive_drop', 'negative_drop', 'length', 'updated_at');
            $itinerary->user->makeHidden('id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added', 'created_at', 'updated_at');
            $itinerary->image->makeHidden('id', 'created_at', 'updated_at');
            $itinerary->tagCategorie->makeHidden(['created_at', 'updated_at', 'pivot', 'taxonomy_id']);
            foreach ($itinerary->tagCategorie as $tagCategorie) {
                $tagCategorie->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
            }
            $itinerary->tagAccessibility->makeHidden(['created_at', 'updated_at', 'pivot', 'taxonomy_id']);
            foreach ($itinerary->tagAccessibility as $tagAccessibility) {
                $tagAccessibility->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
            }
            $itinerary->append('formatted_updated_at');
            foreach ($itinerary->steps as $step) {
                $step->makeHidden(['created_at',  'itinerary_id', 'updated_at']);
                $step->append('formatted_updated_at');
                $step->images->makeHidden(['created_at', 'updated_at', 'id', 'pivot']);
            }

            // Return a success response with the retrieved itinerary
            return $this->sendSuccess($itinerary, 'Itinerary retrieved successfully');
        } else {
            // Return an error response if the itinerary is not found
            return $this->sendError('Itinerary not found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItineraryRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateItineraryRequest $request, string $id)
    {
        // Find the itinerary by ID
        $itinerary = Itinerary::find($id);

        if ($itinerary) {
            try {
                // Handle image upload if present
                if ($request->hasFile('image')) {
                    $imageFile = $request->file('image');
                    $extension = $imageFile->getClientOriginalExtension();
                    $newFilename = time() . '_' . uniqid() . '.' . $extension;
                    $imagePath = $imageFile->storeAs('images', $newFilename,  'public');

                    if (!$imagePath) {
                        return $this->sendError('Image upload failed');
                    }

                    // Create a new Image model
                    $image = Image::create([
                        'url' => $newFilename,
                        'alt_attr' => $request->input('image_description'),
                    ]);

                    // Update the itinerary with the new image ID
                    $itinerary->update(['image_id' => $image->id]);

                    // Delete the old image and its associated model
                    Storage::disk('public')->delete($itinerary->image->path);
                    $itinerary->image->delete();
                }

                // Filter the request data and update the itinerary
                $data = array_filter([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'type' => $request->input('type'),
                    'estimated_time' => $request->input('estimated_time'),
                    'difficulty' => $request->input('difficulty'),
                    'source' => $request->input('source'),
                    'pdf_url' => $request->input('pdf_url'),
                    'image_id' => isset($image) ? $image->id : $itinerary->image_id,
                ], function ($value) {
                    return $value !== null;
                });

                $itinerary->update($data);

                // Mettre à jour les catégories de tags de l'itinéraire
                if ($request->has('tagCategories')) {
                    $tagCategories = TagCategorie::find($request->input('tagCategories'));
                    $itinerary->tagCategories()->sync($tagCategories);
                }

                // Mettre à jour les tags d'accessibilité de l'itinéraire
                if ($request->has('tagAccessibilities')) {
                    $tagAccessibilities = TagAccessibility::find($request->input('tagAccessibilities'));
                    $itinerary->tagAccessibilities()->sync($tagAccessibilities);
                }

                // Process the steps if present in the request
                if ($request->has('steps')) {
                    foreach ($request->input('steps') as $index => $stepData) {
                        if (isset($stepData['id'])) {
                            // If the step has an ID, it's an update or delete operation
                            $step = Step::find($stepData['id']);
                            if (isset($stepData['delete']) && $stepData['delete'] == true) {
                                $imageId = $step->image_id;
                                if ($imageId) {
                                    // Detach the image from the step
                                    $step->images()->detach($imageId);
                                    $image = Image::find($imageId);
                                    if ($image) {
                                        // Delete the image and its associated model
                                        $imagePath = str_replace('/storage/', '', $image->url);
                                        Storage::disk('public')->delete($imagePath);
                                        $image->delete();
                                    }
                                }
                                // Delete the step
                                $step->delete();
                            } else {
                                // Update the step
                                if (isset($stepData['image'])) {
                                    // Si une nouvelle image a été fournie

                                    // Récupérer l'ID de l'ancienne image
                                    $oldImageId = $step->image_id;

                                    if ($oldImageId) {
                                        // Supprimer l'entrée de la table pivot
                                        $step->images()->detach($oldImageId);

                                        // Trouver l'ancienne image par son ID
                                        $oldImage = Image::find($oldImageId);

                                        if ($oldImage) {
                                            // Supprimer l'ancienne image
                                            $imagePath = str_replace('/storage/', '', $oldImage->url);
                                            Storage::disk('public')->delete($imagePath);
                                            $oldImage->delete();
                                        }
                                    }

                                    // Créer une nouvelle image et l'attacher à l'étape

                                    $imageFile = $stepData['image'];
                                    $extension = $imageFile->getClientOriginalExtension();
                                    $newFilename = time() . '_' . uniqid() . '.' . $extension;
                                    $imagePath = $imageFile->storeAs('images', $newFilename, 'public');
                                    $newImage = Image::create([
                                        'url' => $newFilename,
                                        'alt_attr' => $stepData['image_description'],
                                    ]);

                                    $step->images()->attach($newImage->id);

                                    // Supprimer l'image du tableau de données de l'étape
                                    unset($stepData['image']);
                                }

                                $step->update($stepData);
                            }
                        } else {
                            // Si l'étape n'a pas d'ID, c'est un ajout
                            if ($request->hasFile("steps.$index.stepImage")) {
                                $imageFile = $request->file("steps.$index.stepImage");
                                $extension = $imageFile->getClientOriginalExtension();
                                $newFilename = time() . '_' . uniqid() . '.' . $extension;
                                $imagePath = $imageFile->store('images', $newFilename, 'public');

                                $stepImage = Image::create([
                                    'url' => $newFilename,
                                    'alt_attr' => $stepData['image_description'],
                                ]);
                            }

                            $newStep = Step::create([
                                'name' => $stepData['name'],
                                'description' => $stepData['description'],
                                'adress' => $stepData['address'],
                                'latitude' => $stepData['latitude'],
                                'longitude' => $stepData['longitude'],
                                'order' => $stepData['order'],
                                'itinerary_id' => $itinerary->id,
                                'external_link' => $step['external_url'] ?? null,
                            ]);
                            if (isset($stepImage)) {
                                $newStep->images()->attach($stepImage->id);
                            }
                        }
                    }
                }


                $itinerary->load('steps', 'tagCategorie.taxonomy', 'tagAccessibility.taxonomy', 'user');
                $itinerary->makeHidden('created_at', 'user_id', 'image_id', 'tag_categorie_id', 'tag_accessibility_id', 'positive_drop', 'negative_drop', 'length', 'updated_at');
                $itinerary->user->makeHidden('id', 'last_name', 'first_name', 'email', 'password', 'email_verified_at', 'email_verification', 'last_login', 'number_path_added', 'created_at', 'updated_at');
                $itinerary->image->makeHidden('id', 'created_at', 'updated_at');
                $itinerary->tagCategorie->makeHidden(['created_at', 'updated_at', 'pivot', 'taxonomy_id']);
                foreach ($itinerary->tagCategorie as $tagCategorie) {
                    $tagCategorie->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
                }
                $itinerary->tagAccessibility->makeHidden(['created_at', 'updated_at', 'pivot', 'taxonomy_id']);
                foreach ($itinerary->tagAccessibility as $tagAccessibility) {
                    $tagAccessibility->taxonomy->makeHidden(['id', 'created_at', 'updated_at']);
                }
                $itinerary->append('formatted_updated_at');
                foreach ($itinerary->steps as $step) {
                    $step->makeHidden(['created_at',  'itinerary_id', 'updated_at']);
                    $step->append('formatted_updated_at');
                }
                return $this->sendSuccess($itinerary, 'Itinerary updated successfully');
            } catch (\Exception $e) {
                return $this->sendError('Error creating itinerary', $e->getMessage());
            }
        } else {
            return $this->sendError('Itinerary not found', 404);
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
