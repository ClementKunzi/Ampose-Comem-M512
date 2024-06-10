<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Favorite; 

class FavoriteController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'itinerary_id' => [
                'required',
                'integer',
                'exists:itineraries,id',
            ]
        ]);

        try {
            $user_id = auth()->id();
            $existingFavorite = Favorite::where('itinerary_id', $request->itinerary_id)
                ->where('user_id', $user_id)
                ->exists();
            if ($existingFavorite) {
                return $this->sendError('This itinerary is already a favorite for the user.', 422);
            } else {
                $favorite = Favorite::create([
                    'user_id' => $user_id,
                    'itinerary_id' => $request->itinerary_id,
                ]);
                $favorite->makeHidden("updated_at", "created_at");

                return $this->sendSuccess($favorite, 'Favorite created successfully', 200);
            }
        } catch (\Exception $e) {
            return $this->sendError('Error creating favorite', ['error' => $e->getMessage()], 500);
        }
     }

    public function destroy(string $id)
    {
        $favorite = Favorite::find($id);

        if (!$favorite) {
            return $this->sendErrors('Favorite not found', [], 404);
        }

        try {
            $favorite->delete();
            return $this->sendSuccess([], 'Favorite deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrors('Error deleting favorite', ['error' => $e->getMessage()], 500);
        }
    }
}
