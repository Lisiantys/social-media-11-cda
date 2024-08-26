<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function user(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'pseudo' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(['message' => 'Connexion réussie', 'user' => Auth::user()]);
        }

        Log::error('Login failed for user: ', $credentials);

        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
