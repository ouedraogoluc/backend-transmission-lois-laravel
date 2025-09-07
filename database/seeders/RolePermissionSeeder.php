<?php
// database/seeders/RolePermissionSeeder.php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Trouver ou créer le rôle "Super Admin"
        $role = Role::firstOrCreate([
            'slug' => 'super-admin',
        ], [
            'name' => 'Super Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assigner toutes les permissions au rôle "Super Admin"
        $permissions = Permission::all();
        $role->permissions()->sync($permissions->pluck('id'));
    }
}