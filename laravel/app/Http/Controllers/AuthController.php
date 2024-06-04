<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(RegisterRequest $request)
    {
        if ($request->profile_picture) {
            $image = $request->file('profile_picture');
            $imageName = $image->store('profile_pictures', 'public');
            $imagePath = 'storage/' . $imageName;
        } else {
            $imagePath = null;
        }
        $user = new User([
            'username'  => $request->username,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verification' => true,
            'email_verified_at' => null,
            'last_login' => null,
            'number_path_added' => 0,
            'profile_picture' => $imagePath,

        ]);
        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $tokenParts = explode('|', $tokenResult->plainTextToken);
            $token = end($tokenParts);

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @return [string] accessToken
     * @return [string] tokenType
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        //return response()->json($request->user()->makeHidden(['email_verified_at', 'email_verification', 'last_login',  'created_at', 'updated_at', 'password', 'remember_token']));
        $user = $request->user()->load('itineraries.image');
        $user->makeHidden(['email_verified_at', 'email_verification', 'last_login',  'created_at', 'updated_at', 'password', 'remember_token']);
        $user->itineraries->makeHidden(['created_at', 'updated_at', 'user_id', 'image_id']);
        $user->itineraries->each(function ($itinerary) {
            $itinerary->image->makeHidden(['created_at', 'updated_at', 'id']);
        });
        $user->itineraries->append('formatted_updated_at');

        return response()->json($user);
    }
}
