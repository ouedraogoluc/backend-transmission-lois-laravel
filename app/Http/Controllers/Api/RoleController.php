<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    // Lister tous les rôles
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    // Afficher un rôle spécifique
    public function show($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        return response()->json($role, 200);
    }

    // Modifier un rôle
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'slug' => 'sometimes|string|unique:roles,slug,' . $role->id,
        ]);

        $role->update($request->only(['name', 'slug']));
        return response()->json(['message' => 'Role updated successfully', 'role' => $role], 200);
    }



    public function assignPermissions(Request $request, $roleId)
    {
        try {
            Log::info("Début de l'assignation des permissions au rôle ID: {$roleId}");

            // Valider la requête
            $validatedData = $request->validate([
                'permission_ids' => 'required|array',
                'permission_ids.*' => 'exists:permissions,id',
            ]);

            Log::info("Données validées : ", $validatedData);

            // Trouver le rôle
            $role = Role::find($roleId);

            if (!$role) {
                Log::warning("Rôle non trouvé avec ID: {$roleId}");
                return response()->json(['error' => 'Rôle non trouvé.'], 404);
            }

            Log::info("Rôle trouvé : ", ['id' => $role->id, 'name' => $role->name]);

            // Assigner les permissions au rôle
            $role->permissions()->sync($validatedData['permission_ids']);
            Log::info("Permissions assignées avec succès au rôle ID: {$roleId}");

            return response()->json([
                'message' => 'Permissions assignées avec succès.',
                'role' => $role->load('permissions'),
            ], 200);
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'assignation des permissions au rôle ID: {$roleId}", [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Une erreur est survenue.'], 500);
        }
    }

}