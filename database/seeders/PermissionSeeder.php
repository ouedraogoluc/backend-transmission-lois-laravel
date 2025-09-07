<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Gestion des Lois
            ['name' => 'view_lois', 'description' => 'Voir toutes les lois'],
            ['name' => 'create_lois', 'description' => 'Créer une nouvelle loi'],
            ['name' => 'edit_lois', 'description' => 'Modifier une loi'],
            ['name' => 'delete_lois', 'description' => 'Supprimer une loi'],
            ['name' => 'transmit_lois_sg', 'description' => 'Transmettre une loi au SG du MJDHRI'],
            ['name' => 'transmit_lois_dgri', 'description' => 'Transmettre une loi à la DGRI'],
            ['name' => 'transmit_lois_drip', 'description' => 'Transmettre une loi à la DRIP'],
            ['name' => 'transmit_lois_cabinet_ministre', 'description' => 'Transmettre une loi au Cabinet du Ministre'],
            ['name' => 'transmit_lois_premier_ministre', 'description' => 'Transmettre une loi au Cabinet du Premier Ministre'],
            ['name' => 'transmit_lois_commissaire_gouvernement', 'description' => 'Transmettre une loi au Commissaire du Gouvernement'],
            ['name' => 'transmit_lois_alt', 'description' => 'Transmettre une loi à l\'ALT'],
            ['name' => 'close_lois', 'description' => 'Clôturer une loi'],

            // Gestion des Rapports
            ['name' => 'view_reports', 'description' => 'Voir tous les rapports'],
            ['name' => 'create_reports', 'description' => 'Créer un rapport'],
            ['name' => 'edit_reports', 'description' => 'Modifier un rapport'],
            ['name' => 'delete_reports', 'description' => 'Supprimer un rapport'],

            // Gestion des Sessions
            ['name' => 'view_sessions', 'description' => 'Voir toutes les sessions'],
            ['name' => 'create_sessions', 'description' => 'Créer une session'],
            ['name' => 'edit_sessions', 'description' => 'Modifier une session'],
            ['name' => 'delete_sessions', 'description' => 'Supprimer une session'],

            // Gestion des Structures
            ['name' => 'view_structures', 'description' => 'Voir toutes les structures'],
            ['name' => 'create_structures', 'description' => 'Créer une structure'],
            ['name' => 'edit_structures', 'description' => 'Modifier une structure'],
            ['name' => 'delete_structures', 'description' => 'Supprimer une structure'],

            // Gestion des Utilisateurs
            ['name' => 'view_users', 'description' => 'Voir tous les utilisateurs'],
            ['name' => 'create_users', 'description' => 'Créer un utilisateur'],
            ['name' => 'edit_users', 'description' => 'Modifier un utilisateur'],
            ['name' => 'delete_users', 'description' => 'Supprimer un utilisateur'],

            // Gestion des Rôles
            ['name' => 'view_roles', 'description' => 'Voir tous les rôles'],
            ['name' => 'create_roles', 'description' => 'Créer un rôle'],
            ['name' => 'edit_roles', 'description' => 'Modifier un rôle'],
            ['name' => 'delete_roles', 'description' => 'Supprimer un rôle'],

            // Gestion des Permissions
            ['name' => 'view_permissions', 'description' => 'Voir toutes les permissions'],
            ['name' => 'assign_permissions', 'description' => 'Assigner des permissions à un rôle'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'description' => $permission['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}