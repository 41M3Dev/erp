<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class StatistiqueStockController extends Controller
{
    public function index()
    {
        $total       = Stock::count();
        $valeurAchat = Stock::sum(DB::raw('quantite * prix_achat'));
        $valeurVente = Stock::sum(DB::raw('quantite * prix_vente'));

        $sousAlerte = Stock::whereColumn('quantite', '<=', 'seuil_alerte')
            ->where('seuil_alerte', '>', 0)
            ->count();

        $topProduits = Stock::select('nom_produit', 'quantite', 'prix_vente')
            ->orderByDesc('quantite')
            ->limit(10)
            ->get();

        return response()->json([
            'total_produits'    => $total,
            'valeur_achat'      => $valeurAchat,
            'valeur_vente'      => $valeurVente,
            'produits_alertes'  => $sousAlerte,
            'top_produits'      => $topProduits,
        ]);
    }
}
