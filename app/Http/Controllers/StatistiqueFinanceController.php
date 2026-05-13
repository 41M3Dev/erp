<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StatistiqueFinanceController extends Controller
{
    public function index()
    {
        $stats = DB::table('finances')->select(
            DB::raw("SUM(CASE WHEN type_operation = 'revenu'  THEN montant ELSE 0 END) as revenus"),
            DB::raw("SUM(CASE WHEN type_operation = 'dépense' THEN montant ELSE 0 END) as depenses"),
            DB::raw("SUM(CASE WHEN type_operation = 'facture' THEN montant ELSE 0 END) as factures"),
            DB::raw("SUM(CASE WHEN type_operation = 'taxe'    THEN montant ELSE 0 END) as taxes"),
        )->first();

        $parStatut = DB::table('finances')
            ->select('statut', DB::raw('COUNT(*) as total'))
            ->groupBy('statut')
            ->get();

        return response()->json([
            'revenus'    => $stats->revenus   ?? 0,
            'depenses'   => $stats->depenses  ?? 0,
            'factures'   => $stats->factures  ?? 0,
            'taxes'      => $stats->taxes     ?? 0,
            'solde'      => ($stats->revenus ?? 0) - ($stats->depenses ?? 0),
            'par_statut' => $parStatut,
        ]);
    }
}
