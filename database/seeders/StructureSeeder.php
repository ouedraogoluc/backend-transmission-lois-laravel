<?php

namespace Database\Seeders;

use App\Models\Structure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StructureSeeder extends Seeder
{
    public function run()
    {
        $ministeres = [
            ['code' => 'MDFC', 'nom' => 'Ministère de la Défense et des Anciens Combattants'],
            ['code' => 'MS', 'nom' => 'Ministère de la Sécurité'],
            ['code' => 'MATDS', 'nom' => 'Ministère de l’Administration Territoriale, de la Décentralisation et de la Sécurité'],
            ['code' => 'MJDRI', 'nom' => 'Ministère de la Justice, des Droits Humains et des Relations avec les Institutions'],
            ['code' => 'MAEC', 'nom' => 'Ministère des Affaires Étrangères et de la Coopération'],
            ['code' => 'MEFP', 'nom' => 'Ministère de l’Économie, des Finances et du Plan'],
            ['code' => 'MDICAP', 'nom' => 'Ministère du Développement Industriel, du Commerce, de l’Artisanat et des PME'],
            ['code' => 'MTMUSR', 'nom' => 'Ministère des Transports, de la Mobilité Urbaine et de la Sécurité Routière'],
            ['code' => 'MID', 'nom' => 'Ministère des Infrastructures et du Désenclavement'],
            ['code' => 'MARA', 'nom' => 'Ministère de l’Agriculture, des Ressources Animales et Halieutiques'],
            ['code' => 'MSHP', 'nom' => 'Ministère de la Santé et de l’Hygiène Publique'],
            ['code' => 'MENAPLN', 'nom' => 'Ministère de l’Éducation Nationale, de l’Alphabétisation et de la Promotion des Langues Nationales'],
            ['code' => 'MESRI', 'nom' => 'Ministère de l’Enseignement Supérieur, de la Recherche et de l’Innovation'],
            ['code' => 'MSJE', 'nom' => 'Ministère des Sports, de la Jeunesse et de l’Emploi'],
            ['code' => 'MCCAT', 'nom' => 'Ministère de la Communication, de la Culture, des Arts et du Tourisme'],
            ['code' => 'MTDPCE', 'nom' => 'Ministère de la Transition Digitale, des Postes et des Communications Électroniques'],
            ['code' => 'MEEA', 'nom' => 'Ministère de l’Environnement, de l’Eau et de l’Assainissement'],
            ['code' => 'MSAHRNG', 'nom' => 'Ministère de la Solidarité, de l’Action Humanitaire et du Genre'],
            ['code' => 'MMC', 'nom' => 'Ministère des Mines et des Carrières'],
            ['code' => 'MHUV', 'nom' => 'Ministère de l’Habitat, de l’Urbanisme et de la Ville'],
            ['code' => 'ALT', 'nom' => 'Assemblée Législative de la Transition'],
            ['code' => 'DGRI', 'nom' => 'Direction Générale des Relations avec les Institutions'],
            ['code' => 'DRIP', 'nom' => 'Direction des Relations avec les Institutions Parlementaires'],
            ['code' => 'SGMJDRI', 'nom' => 'Secrétariat Général du Ministère de la Justice, des Droits Humains et des Relations avec les Institutions'],
            ['code' => 'CMJ', 'nom' => 'Cabinet du Ministre de la Justice'],
            ['code' => 'CPM', 'nom' => 'Cabinet du Premier Ministre'],
        ];

        foreach ($ministeres as $ministere) {
            Structure::create([ 
                'code' => $ministere['code'],
                'nom' => $ministere['nom'],
            ]);
        }
    }
    }

