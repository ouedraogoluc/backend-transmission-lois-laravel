<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
public function register(Request $request)
{
    Log::info('Tentative d\'enregistrement d\'un utilisateur', ['email' => $request->email]);

    $validated = $request->validate([
        'last_name' => 'required|string',
        'first_name' => 'required|string',
        'service' => 'nullable|string', // Make service optional
        'fonction' => 'required|string',
        'phone' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:3',
        'service_id' => 'required|exists:services,id', // Require service_id
        'structure_id' => 'required|exists:structures,id',
    ]);

    try {
        $user = User::create([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'service' => $validated['service'] ?? null,
            'fonction' => $validated['fonction'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => true,
            'service_id' => $validated['service_id'],
            'structure_id' => $validated['structure_id'],
        ]);

        Log::info('Utilisateur enregistré avec succès', ['user_id' => $user->id]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    } catch (\Exception $e) {
        Log::error('Erreur lors de l\'enregistrement', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Erreur lors de l\'enregistrement'], 500);
    }
}

    public function login(Request $request)
    {
        Log::info('Tentative de connexion', ['email' => $request->email]);

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            Log::warning('Échec de connexion', ['email' => $validated['email']]);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        Log::info('Connexion réussie', ['user_id' => $user->id]);

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(Request $request)
    {
        Log::info('Déconnexion', ['user_id' => $request->user()->id]);
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    // UserController.php

    public function getCurrentUser(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
    }
}
