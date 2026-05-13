<?php

namespace Database\Seeders;

use App\Models\Fournisseur;
use Illuminate\Database\Seeder;

class FournisseurSeeder extends Seeder
{
    public function run(): void
    {
        $fournisseurs = [
            ['nom' => 'TechSupply SAS',    'contact' => 'Paul Girard',   'email' => 'contact@techsupply.fr',  'telephone' => '0102030401', 'adresse' => '12 rue de la Paix, Paris',       'site_web' => 'https://techsupply.fr'],
            ['nom' => 'Bureau Pro SARL',   'contact' => 'Marie Blanc',   'email' => 'info@bureupro.fr',       'telephone' => '0102030402', 'adresse' => '45 av. Gambetta, Lyon',          'site_web' => 'https://bureapro.fr'],
            ['nom' => 'LogiStock SA',      'contact' => 'Luc Renard',    'email' => 'ventes@logistock.fr',    'telephone' => '0102030403', 'adresse' => '8 bd Haussmann, Bordeaux',       'site_web' => 'https://logistock.fr'],
            ['nom' => 'MobilierPlus',      'contact' => 'Nathalie Roy',  'email' => 'nroy@mobilierplus.fr',   'telephone' => '0102030404', 'adresse' => '3 impasse des Lilas, Nantes',    'site_web' => null],
            ['nom' => 'Fournitures Delta', 'contact' => 'Eric Moulin',   'email' => 'eric@fournidelta.fr',    'telephone' => '0102030405', 'adresse' => '22 rue Voltaire, Marseille',     'site_web' => 'https://fournidelta.fr'],
        ];

        foreach ($fournisseurs as $data) {
            Fournisseur::firstOrCreate(['email' => $data['email']], $data);
        }
    }
}
