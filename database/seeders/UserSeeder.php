<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'superadmin',  'email' => 'superadmin@erp.fr',  'role' => 'superadmin'],
            ['username' => 'admin',        'email' => 'admin@erp.fr',       'role' => 'admin'],
            ['username' => 'rh.martin',   'email' => 'rh.martin@erp.fr',   'role' => 'rh'],
            ['username' => 'rh.lefebvre', 'email' => 'rh.lefebvre@erp.fr', 'role' => 'rh'],
            ['username' => 'finance.bernard', 'email' => 'finance.bernard@erp.fr', 'role' => 'finance'],
            ['username' => 'finance.moreau',  'email' => 'finance.moreau@erp.fr',  'role' => 'finance'],
            ['username' => 'manager.dubois',  'email' => 'manager.dubois@erp.fr',  'role' => 'manager'],
            ['username' => 'manager.laurent', 'email' => 'manager.laurent@erp.fr', 'role' => 'manager'],
            ['username' => 'livreur.simon',   'email' => 'livreur.simon@erp.fr',   'role' => 'livreur'],
            ['username' => 'employe.petit',   'email' => 'employe.petit@erp.fr',   'role' => 'employe'],
            ['username' => 'employe.richard', 'email' => 'employe.richard@erp.fr', 'role' => 'employe'],
        ];

        foreach ($users as $data) {
            $user = Utilisateur::firstOrCreate(
                ['username' => $data['username']],
                [
                    'email'       => $data['email'],
                    'mot_de_passe' => Hash::make('Password123!'),
                ]
            );

            $role = Role::where('nom_role', $data['role'])->first();
            if ($role && !$user->roles->contains('id_role', $role->id_role)) {
                $user->roles()->attach($role->id_role);
            }
        }
    }
}
