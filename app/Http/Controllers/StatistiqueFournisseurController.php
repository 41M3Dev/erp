<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;

class StatistiqueFournisseurController extends Controller
{
    public function index()
    {
        $total = Fournisseur::count();

        $commandesParFournisseur = Commande::select('id_fournisseur', DB::raw('COUNT(*) as total_commandes'))
            ->groupBy('id_fournisseur')
            ->with('fournisseur')
            ->orderByDesc('total_commandes')
            ->limit(10)
            ->get();

        return response()->json([
            'total_fournisseurs'          => $total,
            'commandes_par_fournisseur'   => $commandesParFournisseur,
        ]);
    }
}
