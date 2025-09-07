<?php
// database/seeders/DefaultUserSeeder.php
// database/seeders/DefaultUserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    public function run()
    {
        // Créer un utilisateur par défaut
        $user = User::firstOrCreate([
            'email' => 'admin@system.com',
        ], [
            'last_name' => 'Admin',
            'first_name' => 'System',
            'service' => 'Administration',
            'fonction' => 'Super Admin',
            'phone' => '1234567890',
            'password' => Hash::make('password123'), 
            'status' => true, // Actif par défaut
            'structure_id' => 1, // Actif par défaut
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trouver ou créer le rôle "Super Admin"
        $role = Role::firstOrCreate([
            'slug' => 'super-admin',
        ], [
            'name' => 'Super Admin',
            'description' => 'Rôle avec toutes les permissions',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
//$2y$12$W.YRum7PaSyniXDCggmgje1t3WAa4LpK/87y9nFZ946rt3mm5LYei
        // Assigner toutes les permissions au rôle "Super Admin"
        $permissions = Permission::all();
        $role->permissions()->sync($permissions->pluck('id')); // Utiliser sync pour éviter les doublons

        // Assigner le rôle "Super Admin" à l'utilisateur par défaut
        $user->roles()->sync([$role->id]); // Utiliser sync pour éviter les doublons
    }
}
