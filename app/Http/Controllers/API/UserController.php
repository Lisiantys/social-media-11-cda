<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'message' => 'Utilisateurs récupérés avec succès',
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request["password"] = Hash::make($request["password"]);

        $user = User::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur trouvé avec succès',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        Log::info('Received request to update user:', $request->all());

        try {
            $validatedData = $request->validate([
                'pseudo' => ['sometimes', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['sometimes', 'string', 'min:8'],
            ]);

            Log::info('Validated data:', $validatedData);

            if ($request->filled('password')) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            Log::info('Updating user with data:', $validatedData);

            $user->update($validatedData);

            return response()->json(['message' => 'Profil mis à jour avec succès', 'user' => $user]);
        } catch (ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Request $request)
     {
         $user = $request->user();
         //Auth::logout();
         $request->session()->invalidate();
         $request->session()->regenerateToken();
         $user->delete();

         return response()->json(['message' => 'Utilisateur supprimé avec succès']);
     }
}
