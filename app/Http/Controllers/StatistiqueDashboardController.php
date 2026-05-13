<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Conge;
use App\Models\Stock;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\DB;

class StatistiqueDashboardController extends Controller
{
    public function index()
    {
        $employes = [
            'actifs'   => Employe::where('actif', 1)->count(),
            'inactifs' => Employe::where('actif', 0)->count(),
        ];

        $finances = DB::table('finances')->select(
            DB::raw("SUM(CASE WHEN type_operation = 'revenu'  THEN montant ELSE 0 END) as revenus"),
            DB::raw("SUM(CASE WHEN type_operation = 'dépense' THEN montant ELSE 0 END) as depenses"),
        )->first();

        $stocks = [
            'total'         => Stock::count(),
            'sous_alerte'   => Stock::whereColumn('quantite', '<=', 'seuil_alerte')
                ->where('seuil_alerte', '>', 0)->count(),
        ];

        $conges = [
            'en_attente' => Conge::where('statut', 'En attente')->count(),
            'valides'    => Conge::where('statut', 'Validé')->count(),
        ];

        return response()->json([
            'employes'  => $employes,
            'finances'  => [
                'revenus'  => $finances->revenus  ?? 0,
                'depenses' => $finances->depenses ?? 0,
                'solde'    => ($finances->revenus ?? 0) - ($finances->depenses ?? 0),
            ],
            'stocks'    => $stocks,
            'conges'    => $conges,
            'fournisseurs' => Fournisseur::count(),
        ]);
    }
}
