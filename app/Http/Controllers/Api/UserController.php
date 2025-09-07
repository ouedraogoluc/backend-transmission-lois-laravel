<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PasswordGenerated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Récupérer tous les utilisateurs
    public function getUsersAll()
    {
        $users = User::with('structure', 'roles')->get();
        return response()->json($users, 200);
    }

    // Récupérer un utilisateur par ID
    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    // Mettre à jour un utilisateur
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'last_name' => 'sometimes|string',
            'first_name' => 'sometimes|string',
            'service' => 'sometimes|string',
            'fonction' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'role_id' => 'sometimes|exists:roles,id',
            'structure_id' => 'sometimes|exists:structures,id',
        ]);

        $user->update([
            'last_name' => $request->last_name ?? $user->last_name,
            'first_name' => $request->first_name ?? $user->first_name,
            'service' => $request->service ?? $user->service,
            'fonction' => $request->fonction ?? $user->fonction,
            'phone' => $request->phone ?? $user->phone,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role_id' => $request->role_id ?? $user->role_id,
            'structure_id' => $request->structure_id ?? $user->structure_id,
        ]);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    // Supprimer un utilisateur
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // Assigner des rôles à un utilisateur
    public function assignRoles(Request $request, $userId)
    {
        // Valider la requête
        $request->validate([
            'role_ids' => 'required|array', // Liste des IDs des rôles
            'role_ids.*' => 'exists:roles,id', // Chaque ID doit exister dans la table roles
        ]);

        // Trouver l'utilisateur
        $user = User::findOrFail($userId);

        // Assigner les rôles à l'utilisateur
        $user->roles()->sync($request->role_ids);

        return response()->json([
            'message' => 'Rôles assignés avec succès.',
            'user' => $user->load('roles'), // Charger les rôles associés
        ]);
    }

    // UserController.php
    // public function generatePassword($userId)
    // {
    //     $user = User::find($userId);
    //     if (!$user) {
    //         return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
    //     }
    //     // Générer un mot de passe aléatoire
    //     $password = Str::random(10); // Utilisez une méthode sécurisée pour générer un mot de passe

    //     // Mettre à jour le mot de passe de l'utilisateur
    //     $user->password = Hash::make($password);
    //     $user->save();

    //     // Envoyer le mot de passe par e-mail
    //     Mail::to($user->email)->send(new PasswordGenerated($password));

    //     return response()->json(['success' => true, 'message' => 'Mot de passe généré et envoyé par e-mail']);
    // }

    public function generatePassword($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }

        // Générer un mot de passe aléatoire sécurisé
        $password = Str::random(10) . rand(0, 9) . '!@#';

        // Mettre à jour le mot de passe de l'utilisateur
        $user->password = Hash::make($password);
        $user->save();

        // Envoyer le mot de passe par e-mail
        try {
            Mail::to($user->email)->send(new PasswordGenerated($password));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Échec de l\'envoi de l\'e-mail : ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mot de passe généré et envoyé par e-mail',
            'password' => env('APP_DEBUG') ? $password : null
        ]);
    }
 

    public function changePassword(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non authentifié'], 401);
        }

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Ancien mot de passe incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Mot de passe changé avec succès']);
    }




}
