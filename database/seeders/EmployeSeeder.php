<?php

namespace Database\Seeders;

use App\Models\Employe;
use Illuminate\Database\Seeder;

class EmployeSeeder extends Seeder
{
    public function run(): void
    {
        $employes = [
            ['nom' => 'Martin',   'prenom' => 'Sophie',   'email' => 'sophie.martin@erp.fr',   'telephone' => '0601010101', 'departement' => 'rh',          'date_embauche' => '2019-03-15'],
            ['nom' => 'Lefebvre', 'prenom' => 'Thomas',   'email' => 'thomas.lefebvre@erp.fr', 'telephone' => '0601010102', 'departement' => 'rh',          'date_embauche' => '2020-06-01'],
            ['nom' => 'Bernard',  'prenom' => 'Claire',   'email' => 'claire.bernard@erp.fr',  'telephone' => '0601010103', 'departement' => 'finance',     'date_embauche' => '2018-11-20'],
            ['nom' => 'Moreau',   'prenom' => 'Julien',   'email' => 'julien.moreau@erp.fr',   'telephone' => '0601010104', 'departement' => 'finance',     'date_embauche' => '2021-02-08'],
            ['nom' => 'Dubois',   'prenom' => 'Marc',     'email' => 'marc.dubois@erp.fr',     'telephone' => '0601010105', 'departement' => 'informatique','date_embauche' => '2017-09-01'],
            ['nom' => 'Laurent',  'prenom' => 'Isabelle', 'email' => 'isabelle.laurent@erp.fr','telephone' => '0601010106', 'departement' => 'informatique','date_embauche' => '2022-01-15'],
            ['nom' => 'Simon',    'prenom' => 'Kevin',    'email' => 'kevin.simon@erp.fr',     'telephone' => '0601010107', 'departement' => 'livraison',   'date_embauche' => '2023-04-03'],
            ['nom' => 'Petit',    'prenom' => 'Laura',    'email' => 'laura.petit@erp.fr',     'telephone' => '0601010108', 'departement' => 'employe',     'date_embauche' => '2022-07-18'],
            ['nom' => 'Richard',  'prenom' => 'Antoine',  'email' => 'antoine.richard@erp.fr', 'telephone' => '0601010109', 'departement' => 'employe',     'date_embauche' => '2023-10-01'],
            ['nom' => 'Durand',   'prenom' => 'Emma',     'email' => 'emma.durand@erp.fr',     'telephone' => '0601010110', 'departement' => 'finance',     'date_embauche' => '2020-03-22'],
        ];

        foreach ($employes as $data) {
            Employe::firstOrCreate(['email' => $data['email']], array_merge($data, ['actif' => 1]));
        }
    }
}
