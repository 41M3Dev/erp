<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'superadmin',      'email' => 'superadmin@erp.fr',       'role' => 'superadmin', 'employe_nom' => null],
            ['username' => 'admin',            'email' => 'admin@erp.fr',            'role' => 'admin',      'employe_nom' => null],
            ['username' => 'rh.martin',        'email' => 'rh.martin@erp.fr',        'role' => 'rh',         'employe_nom' => 'Martin'],
            ['username' => 'rh.lefebvre',      'email' => 'rh.lefebvre@erp.fr',      'role' => 'rh',         'employe_nom' => 'Lefebvre'],
            ['username' => 'finance.bernard',  'email' => 'finance.bernard@erp.fr',  'role' => 'finance',    'employe_nom' => 'Bernard'],
            ['username' => 'finance.moreau',   'email' => 'finance.moreau@erp.fr',   'role' => 'finance',    'employe_nom' => 'Moreau'],
            ['username' => 'manager.dubois',   'email' => 'manager.dubois@erp.fr',   'role' => 'manager',    'employe_nom' => 'Dubois'],
            ['username' => 'manager.laurent',  'email' => 'manager.laurent@erp.fr',  'role' => 'manager',    'employe_nom' => 'Laurent'],
            ['username' => 'livreur.simon',    'email' => 'livreur.simon@erp.fr',    'role' => 'livreur',    'employe_nom' => 'Simon'],
            ['username' => 'employe.petit',    'email' => 'employe.petit@erp.fr',    'role' => 'employe',    'employe_nom' => 'Petit'],
            ['username' => 'employe.richard',  'email' => 'employe.richard@erp.fr',  'role' => 'employe',    'employe_nom' => 'Richard'],
        ];

        foreach ($users as $data) {
            $idEmploye = null;
            if ($data['employe_nom']) {
                $employe = Employe::where('nom', $data['employe_nom'])->first();
                if ($employe) {
                    $idEmploye = $employe->id_employe;
                }
            }

            $user = Utilisateur::firstOrCreate(
                ['username' => $data['username']],
                [
                    'email'        => $data['email'],
                    'mot_de_passe' => Hash::make('Password123!'),
                    'id_employe'   => $idEmploye,
                ]
            );

            // Met à jour id_employe si manquant (pour les re-seeds partiels)
            if ($idEmploye && !$user->id_employe) {
                $user->id_employe = $idEmploye;
                $user->save();
            }

            $role = Role::where('nom_role', $data['role'])->first();
            if ($role && !$user->roles->contains('id_role', $role->id_role)) {
                $user->roles()->attach($role->id_role);
            }
        }
    }
}
