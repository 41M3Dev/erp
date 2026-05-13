<?php

namespace Database\Seeders;

use App\Models\Conge;
use App\Models\Employe;
use Illuminate\Database\Seeder;

class CongeSeeder extends Seeder
{
    public function run(): void
    {
        $demandes = [
            ['email' => 'laura.petit@erp.fr',      'type_conge' => 'CP',      'date_debut' => '2025-07-14', 'date_fin' => '2025-07-25', 'statut' => 'Validé',    'commentaires' => 'Congés été'],
            ['email' => 'antoine.richard@erp.fr',  'type_conge' => 'RTT',     'date_debut' => '2025-06-02', 'date_fin' => '2025-06-02', 'statut' => 'Validé',    'commentaires' => null],
            ['email' => 'kevin.simon@erp.fr',      'type_conge' => 'Maladie', 'date_debut' => '2025-04-07', 'date_fin' => '2025-04-09', 'statut' => 'Validé',    'commentaires' => 'Certificat médical fourni'],
            ['email' => 'sophie.martin@erp.fr',    'type_conge' => 'CP',      'date_debut' => '2025-08-04', 'date_fin' => '2025-08-15', 'statut' => 'En attente','commentaires' => 'Vacances'],
            ['email' => 'julien.moreau@erp.fr',    'type_conge' => 'RTT',     'date_debut' => '2025-05-30', 'date_fin' => '2025-05-30', 'statut' => 'En attente','commentaires' => null],
            ['email' => 'emma.durand@erp.fr',      'type_conge' => 'CP',      'date_debut' => '2025-03-10', 'date_fin' => '2025-03-14', 'statut' => 'Annulé',    'commentaires' => 'Annulation personnelle'],
        ];

        foreach ($demandes as $data) {
            $employe = Employe::where('email', $data['email'])->first();
            if (!$employe) continue;

            Conge::firstOrCreate(
                ['id_employe' => $employe->id_employe, 'date_debut' => $data['date_debut']],
                [
                    'type_conge'  => $data['type_conge'],
                    'date_fin'    => $data['date_fin'],
                    'statut'      => $data['statut'],
                    'commentaires'=> $data['commentaires'],
                ]
            );
        }
    }
}
