<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Ministre de la Justice', 'slug' => 'ministre-justice'],
            ['name' => 'Secrétaire Général MJDHRI', 'slug' => 'secretaire-general'],
            ['name' => 'Directeur Général DGRI', 'slug' => 'directeur-dgri'],
            ['name' => 'Chargé d’Études Juridiques', 'slug' => 'charge-etudes-juridiques'],
            ['name' => 'Chargé de la Transmission aux Institutions', 'slug' => 'charge-transmission'],
            ['name' => 'Directeur de la DRIP', 'slug' => 'directeur-drip'],
            ['name' => 'Juriste Analyste', 'slug' => 'juriste-analyste'],
            ['name' => 'Secrétariat de l’ALT', 'slug' => 'secretariat-alt'],
            ['name' => 'Commission des Lois', 'slug' => 'commission-lois'],
        ];

        foreach ($roles as $role) {
            Role::create([ // Utilise le modèle Role pour créer les enregistrements
                'name' => $role['name'],
                'slug' => $role['slug'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
