<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['superadmin', 'admin', 'rh', 'finance', 'manager', 'livreur', 'employe'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['nom_role' => $role]);
        }
    }
}

