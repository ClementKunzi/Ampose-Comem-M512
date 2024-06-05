<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\delete;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::all();
        $images->makeHidden(['created_at', 'updated_at']);
        return response()->json($images);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_attr' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');

            $imageModel = new Image;
            $imageModel->url = '/storage/' . $imagePath;
            $imageModel->alt_attr = $request->input('alt_attr');
            $imageModel->save();
            $imageModel = $imageModel->makeHidden(['created_at', 'updated_at']);

            return $this->sendSuccess($imageModel, 'Image uploaded successfully');
        }

        return $this->sendError('No Image Uploaded', 404);
    }


    /**
     * Display the specified resource.
     */
    public function show($filename)
    {
        $basePath = 'storage/images/';
        $pathToFile = public_path($basePath) . $filename;

        if (!file_exists($pathToFile)) {
            return $this->sendError('File not found.', 404);
        }

        return $this->sendSuccess($pathToFile);
    }

    /**
     * Update the specified resource in storage.
     */

    /*
    public function update(Request $request, string $id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found',
                'errors' => 404,
                'debug' => [
                    'request_data' => $request->all()
                ]
            ], 404);
        }

        // Validation des données
        $validatedData = $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_attr' => 'sometimes|string',
        ]);

        $originalAttributes = $image->getOriginal();

        if ($request->hasFile('image')) {
            // Suppression de l'ancienne image
            $imagePath = str_replace('/storage/', '', $image->url);
            Storage::disk('public')->delete($imagePath);

            // Stockage de la nouvelle image
            $newImage = $request->file('image');
            $imageName = $newImage->store('images', 'public');
            $imagePath = 'storage/' . $imageName;
            $image->url = $imagePath;
        }

        if ($request->exists('alt_attr')) {
            $image->alt_attr = $request->get('alt_attr');
        }

        $updatedAttributes = $image->getAttributes();

        $isUpdated = $originalAttributes != $updatedAttributes;

        if ($isUpdated) {
            $image->save();
            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully',
                'data' => $image,
                'debug' => [
                    'original' => $originalAttributes,
                    'updated' => $updatedAttributes,
                    'request_data' => $request->all()
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No changes were made',
                'errors' => 400,
                'debug' => [
                    'original' => $originalAttributes,
                    'updated' => $updatedAttributes,
                    'request_data' => $request->all()
                ]
            ], 400);
        }
    }*/




    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $image = Image::find($id);

        if ($image) {
            // Remove the '/storage/' prefix from the image URL
            $imagePath = str_replace('/storage/', '', $image->url);

            $deleteSuccess = Storage::disk('public')->delete($imagePath);

            if ($deleteSuccess) {
                $image->delete();
                return $this->sendSuccess(null, 'Image deleted successfully');
            }
        }

        return $this->sendError('Image not found', 404);
    }
}
