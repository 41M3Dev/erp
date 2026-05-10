<?php

namespace App\Http\Controllers;

use App\Models\Conge;

class StatistiquePlanningController extends Controller
{
    public function index()
    {
        $enAttente = Conge::with('employe')
            ->where('statut', 'En attente')
            ->orderBy('date_debut')
            ->get();

        $aVenir = Conge::with('employe')
            ->where('statut', 'Validé')
            ->where('date_debut', '>=', now()->toDateString())
            ->orderBy('date_debut')
            ->get();

        $enCours = Conge::with('employe')
            ->where('statut', 'Validé')
            ->where('date_debut', '<=', now()->toDateString())
            ->where('date_fin', '>=', now()->toDateString())
            ->get();

        return response()->json([
            'en_attente' => $enAttente,
            'a_venir'    => $aVenir,
            'en_cours'   => $enCours,
        ]);
    }
}
