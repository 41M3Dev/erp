<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Salaire;
use Illuminate\Database\Seeder;

class SalaireSeeder extends Seeder
{
    public function run(): void
    {
        $salaires = [
            ['email' => 'sophie.martin@erp.fr',   'montant' => 3200.00],
            ['email' => 'thomas.lefebvre@erp.fr',  'montant' => 2950.00],
            ['email' => 'claire.bernard@erp.fr',   'montant' => 3500.00],
            ['email' => 'julien.moreau@erp.fr',    'montant' => 3100.00],
            ['email' => 'marc.dubois@erp.fr',      'montant' => 4200.00],
            ['email' => 'isabelle.laurent@erp.fr', 'montant' => 3800.00],
            ['email' => 'kevin.simon@erp.fr',      'montant' => 2400.00],
            ['email' => 'laura.petit@erp.fr',      'montant' => 2600.00],
            ['email' => 'antoine.richard@erp.fr',  'montant' => 2550.00],
            ['email' => 'emma.durand@erp.fr',      'montant' => 3300.00],
        ];

        foreach ($salaires as $entry) {
            $employe = Employe::where('email', $entry['email'])->first();
            if (!$employe) continue;

            Salaire::firstOrCreate(
                ['id_employe' => $employe->id_employe, 'date_debut' => '2025-01-01'],
                [
                    'montant'           => $entry['montant'],
                    'date_debut'        => '2025-01-01',
                    'date_fin'          => null,
                    'date_creation'     => now(),
                    'date_modification' => now(),
                ]
            );
        }
    }
}
