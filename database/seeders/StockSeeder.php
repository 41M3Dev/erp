<?php

namespace Database\Seeders;

use App\Models\Fournisseur;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $f1 = Fournisseur::where('nom', 'TechSupply SAS')->first()?->id_fournisseur;
        $f2 = Fournisseur::where('nom', 'Bureau Pro SARL')->first()?->id_fournisseur;
        $f3 = Fournisseur::where('nom', 'LogiStock SA')->first()?->id_fournisseur;
        $f4 = Fournisseur::where('nom', 'MobilierPlus')->first()?->id_fournisseur;

        $produits = [
            ['id_fournisseur' => $f1, 'nom_produit' => 'Ordinateur portable',  'description' => 'Laptop 15" 16Go RAM',   'quantite' => 12, 'seuil_alerte' => 3,  'prix_achat' => 750.00, 'prix_vente' => 1100.00],
            ['id_fournisseur' => $f1, 'nom_produit' => 'Écran 24 pouces',       'description' => 'Moniteur Full HD',      'quantite' => 8,  'seuil_alerte' => 2,  'prix_achat' => 180.00, 'prix_vente' => 280.00],
            ['id_fournisseur' => $f1, 'nom_produit' => 'Clavier sans fil',      'description' => 'Clavier AZERTY',        'quantite' => 25, 'seuil_alerte' => 5,  'prix_achat' => 35.00,  'prix_vente' => 65.00],
            ['id_fournisseur' => $f2, 'nom_produit' => 'Ramette papier A4',     'description' => '500 feuilles 80g/m²',   'quantite' => 2,  'seuil_alerte' => 10, 'prix_achat' => 4.50,   'prix_vente' => 8.00],
            ['id_fournisseur' => $f2, 'nom_produit' => 'Stylos bille (lot 12)', 'description' => 'Stylos bleus Bic',      'quantite' => 40, 'seuil_alerte' => 10, 'prix_achat' => 3.20,   'prix_vente' => 6.00],
            ['id_fournisseur' => $f3, 'nom_produit' => 'Cartouche imprimante',  'description' => 'Cartouche laser noire', 'quantite' => 6,  'seuil_alerte' => 3,  'prix_achat' => 42.00,  'prix_vente' => 75.00],
            ['id_fournisseur' => $f4, 'nom_produit' => 'Chaise de bureau',      'description' => 'Chaise ergonomique',    'quantite' => 4,  'seuil_alerte' => 2,  'prix_achat' => 120.00, 'prix_vente' => 220.00],
            ['id_fournisseur' => $f4, 'nom_produit' => 'Bureau réglable',       'description' => 'Bureau assis-debout',   'quantite' => 2,  'seuil_alerte' => 1,  'prix_achat' => 350.00, 'prix_vente' => 600.00],
        ];

        foreach ($produits as $data) {
            Stock::firstOrCreate(['nom_produit' => $data['nom_produit']], $data);
        }
    }
}
