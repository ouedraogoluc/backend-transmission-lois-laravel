<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions, 200);
    }

    // Afficher une Permission spécifique
    public function show($id)
    {
        $permissions = Permission::find($id);
        if (!$permissions) {
            return response()->json(['message' => 'Permission not found'], 404);
        }
        return response()->json($permissions, 200);
    }

    // Modifier une Permission
    public function update(Request $request, $id)
    {
        $permissions = Permission::find($id);
        if (!$permissions) {
            return response()->json(['message' => 'Permission not found'], 404);
        }
        $request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string|unique:Permissions,code,' . $permissions->id,
        ]);

        $permissions->update($request->only(['nom', 'code']));
        return response()->json(['message' => 'Permission updated successfully', 'Permission' => $permissions], 200);
    }
}
