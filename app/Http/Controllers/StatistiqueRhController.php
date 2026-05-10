<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Absence;
use Illuminate\Support\Facades\DB;

class StatistiqueRhController extends Controller
{
    public function index()
    {
        $congesParStatut = Conge::select('statut', DB::raw('COUNT(*) as total'))
            ->groupBy('statut')
            ->get();

        $congesParType = Conge::select('type_conge', DB::raw('COUNT(*) as total'))
            ->groupBy('type_conge')
            ->get();

        $absencesTotal  = Absence::count();
        $absencesMois   = Absence::whereMonth('date_absence', now()->month)
            ->whereYear('date_absence', now()->year)
            ->count();

        return response()->json([
            'conges_par_statut' => $congesParStatut,
            'conges_par_type'   => $congesParType,
            'absences_total'    => $absencesTotal,
            'absences_ce_mois'  => $absencesMois,
        ]);
    }
}
