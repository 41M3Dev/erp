<?php

namespace Database\Seeders;

use App\Models\Finance;
use App\Models\Fournisseur;
use Illuminate\Database\Seeder;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        $f1 = Fournisseur::where('nom', 'TechSupply SAS')->first()?->id_fournisseur;
        $f2 = Fournisseur::where('nom', 'Bureau Pro SARL')->first()?->id_fournisseur;

        $operations = [
            ['type_operation' => 'revenu',  'description' => 'Prestation client Acme',         'montant' => 8500.00,  'date_operation' => '2025-01-10', 'categorie' => 'Marketing',   'id_fournisseur' => null, 'statut' => 'Payé',       'reference_facture' => 'FAC-2025-001'],
            ['type_operation' => 'revenu',  'description' => 'Vente licences logiciel',         'montant' => 3200.00,  'date_operation' => '2025-01-22', 'categorie' => 'Marketing',   'id_fournisseur' => null, 'statut' => 'Payé',       'reference_facture' => 'FAC-2025-002'],
            ['type_operation' => 'dépense', 'description' => 'Achat matériel informatique',     'montant' => 2340.00,  'date_operation' => '2025-02-03', 'categorie' => 'Fournisseur', 'id_fournisseur' => $f1,  'statut' => 'Payé',       'reference_facture' => 'ACH-2025-001'],
            ['type_operation' => 'dépense', 'description' => 'Fournitures de bureau',           'montant' => 185.50,   'date_operation' => '2025-02-15', 'categorie' => 'Fournisseur', 'id_fournisseur' => $f2,  'statut' => 'Payé',       'reference_facture' => 'ACH-2025-002'],
            ['type_operation' => 'revenu',  'description' => 'Prestation client Beta Corp',     'montant' => 12000.00, 'date_operation' => '2025-03-01', 'categorie' => 'Marketing',   'id_fournisseur' => null, 'statut' => 'Payé',       'reference_facture' => 'FAC-2025-003'],
            ['type_operation' => 'facture', 'description' => 'Abonnement serveurs cloud',       'montant' => 990.00,   'date_operation' => '2025-03-15', 'categorie' => 'Fournisseur', 'id_fournisseur' => null, 'statut' => 'En attente', 'reference_facture' => 'FACT-2025-004'],
            ['type_operation' => 'dépense', 'description' => 'Location locaux Q1',              'montant' => 4500.00,  'date_operation' => '2025-03-31', 'categorie' => 'Marketing',   'id_fournisseur' => null, 'statut' => 'Payé',       'reference_facture' => 'ACH-2025-003'],
            ['type_operation' => 'revenu',  'description' => 'Vente équipements reconditionnés','montant' => 1750.00,  'date_operation' => '2025-04-08', 'categorie' => 'Marketing',   'id_fournisseur' => null, 'statut' => 'Payé',       'reference_facture' => 'FAC-2025-005'],
            ['type_operation' => 'dépense', 'description' => 'Achat consommables impression',   'montant' => 312.00,   'date_operation' => '2025-04-20', 'categorie' => 'Fournisseur', 'id_fournisseur' => $f2,  'statut' => 'Payé',       'reference_facture' => 'ACH-2025-004'],
            ['type_operation' => 'facture', 'description' => 'Maintenance annuelle serveurs',   'montant' => 2800.00,  'date_operation' => '2025-05-02', 'categorie' => 'Fournisseur', 'id_fournisseur' => $f1,  'statut' => 'En attente', 'reference_facture' => 'FACT-2025-005'],
        ];

        foreach ($operations as $data) {
            Finance::firstOrCreate(
                ['reference_facture' => $data['reference_facture']],
                array_merge($data, ['date_creation' => now()])
            );
        }
    }
}
