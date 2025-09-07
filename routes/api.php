<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StructureController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Authentification
    Route::post('/user', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Routes protégées
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'getCurrentUser']);

        // Routes pour les rôles
        Route::get('/roles', [RoleController::class, 'index']);
        Route::get('/roles/{id}', [RoleController::class, 'show']);
        Route::put('/roles/{id}', [RoleController::class, 'update']);
        Route::patch('/roles/{id}', [RoleController::class, 'update']);
        Route::post('/roles/{roleId}/assign-permissions', [RoleController::class, 'assignPermissions']);

        // Routes pour les structures
        Route::get('/structures', [StructureController::class, 'index']);
        Route::post('/structures', [StructureController::class, 'store']); // Ajouté pour la création
        Route::get('/structures/{structure}', [StructureController::class, 'show']);
        Route::put('/structures/{structure}', [StructureController::class, 'update']);
        Route::patch('/structures/{structure}', [StructureController::class, 'update']);
        Route::delete('/structures/{structure}', [StructureController::class, 'destroy']); // Ajouté pour la suppression

        // Routes pour les services
        // Route::get('/structures/{structure}/services', [ServiceController::class, 'index']);
        // Route::post('/structures/{structure}/services', [ServiceController::class, 'store']);
        // Route::get('/structures/{structure}/services/{service}', [ServiceController::class, 'show']);
        // Route::put('/structures/{structure}/services/{service}', [ServiceController::class, 'update']);
        // Route::patch('/structures/{structure}/services/{service}', [ServiceController::class, 'update']);
        // Route::delete('/structures/{structure}/services/{service}', [ServiceController::class, 'destroy']);

       // Routes pour les services
        Route::get('/services', [ServiceController::class, 'index']);
        Route::post('/services', [ServiceController::class, 'store']);
        Route::get('/services/{service}', [ServiceController::class, 'show']);
        Route::put('/services/{service}', [ServiceController::class, 'update']);
        Route::patch('/services/{service}', [ServiceController::class, 'update']);
        Route::delete('/services/{service}', [ServiceController::class, 'destroy']);
        Route::get('/services/structure/{structureId}', [ServiceController::class, 'getByStructure'])->middleware('auth:sanctum');
                // Routes pour les permissions
        Route::get('/permissions', [PermissionController::class, 'index']);
        Route::get('/permissions/{id}', [PermissionController::class, 'show']);
        Route::put('/permissions/{id}', [PermissionController::class, 'update']);
        Route::patch('/permissions/{id}', [PermissionController::class, 'update']);

        // Routes pour les utilisateurs
        Route::get('/users', [UserController::class, 'getUsersAll']);
        Route::get('/users/{id}', [UserController::class, 'getUserById']);
        Route::put('/users/{id}', [UserController::class, 'updateUser']);
        Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
        Route::post('/users/{userId}/assign-roles', [UserController::class, 'assignRoles']);
        Route::post('/users/{userId}/generate-password', [UserController::class, 'generatePassword']);
        Route::post('/change-password', [UserController::class, 'changePassword']);
    });
});
