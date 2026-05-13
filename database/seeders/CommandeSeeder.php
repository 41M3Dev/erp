<?php

namespace Database\Seeders;

use App\Models\Commande;
use App\Models\Fournisseur;
use Illuminate\Database\Seeder;

class CommandeSeeder extends Seeder
{
    public function run(): void
    {
        $f1 = Fournisseur::where('nom', 'TechSupply SAS')->first()?->id_fournisseur;
        $f2 = Fournisseur::where('nom', 'Bureau Pro SARL')->first()?->id_fournisseur;
        $f3 = Fournisseur::where('nom', 'LogiStock SA')->first()?->id_fournisseur;
        $f5 = Fournisseur::where('nom', 'Fournitures Delta')->first()?->id_fournisseur;

        $commandes = [
            ['reference_commande' => 'CMD-2025-001', 'id_fournisseur' => $f1, 'destinataire' => 'Entrepôt Paris',    'statut_livraison' => 'Livré',    'date_creation' => '2025-01-15', 'date_livraison' => '2025-01-22', 'commentaires' => null],
            ['reference_commande' => 'CMD-2025-002', 'id_fournisseur' => $f2, 'destinataire' => 'Bureau Lyon',       'statut_livraison' => 'Livré',    'date_creation' => '2025-02-01', 'date_livraison' => '2025-02-06', 'commentaires' => 'Livraison partielle'],
            ['reference_commande' => 'CMD-2025-003', 'id_fournisseur' => $f3, 'destinataire' => 'Entrepôt Paris',    'statut_livraison' => 'En cours', 'date_creation' => '2025-04-10', 'date_livraison' => '2025-05-20', 'commentaires' => null],
            ['reference_commande' => 'CMD-2025-004', 'id_fournisseur' => $f5, 'destinataire' => 'Siège social',      'statut_livraison' => 'En cours', 'date_creation' => '2025-05-01', 'date_livraison' => '2025-05-25', 'commentaires' => 'Urgent'],
            ['reference_commande' => 'CMD-2025-005', 'id_fournisseur' => $f1, 'destinataire' => 'Entrepôt Bordeaux', 'statut_livraison' => 'Annulé',   'date_creation' => '2025-03-05', 'date_livraison' => null,         'commentaires' => 'Fournisseur indisponible'],
        ];

        foreach ($commandes as $data) {
            Commande::firstOrCreate(
                ['reference_commande' => $data['reference_commande']],
                $data
            );
        }
    }
}
