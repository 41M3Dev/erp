<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Support\Facades\DB;

class StatistiqueLivraisonController extends Controller
{
    public function index()
    {
        $parStatut = Commande::select('statut_livraison', DB::raw('COUNT(*) as total'))
            ->groupBy('statut_livraison')
            ->get();

        $recent = Commande::orderByDesc('date_livraison')->limit(10)->get();

        return response()->json([
            'total'      => Commande::count(),
            'par_statut' => $parStatut,
            'recent'     => $recent,
        ]);
    }
}
