<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // ----------------------------------------
        $employeeDeptStats = Employe::where('actif', 1)
            ->select('departement', DB::raw('COUNT(*) as total'))
            ->groupBy('departement')
            ->get();

        $activeEmployeesCount = Employe::where('actif', 1)->count();

        $financeStats = DB::table('finances')
            ->select(
                DB::raw("SUM(CASE WHEN type_operation = 'revenu' THEN montant ELSE 0 END) as revenus"),
                DB::raw("SUM(CASE WHEN type_operation = 'dépense' THEN montant ELSE 0 END) as depenses"),
                DB::raw("SUM(CASE WHEN type_operation = 'facture' THEN montant ELSE 0 END) as factures"),
            )
            ->first();
        $stockStats = DB::table('stocks')
            ->select('nom_produit', 'quantite')
            ->get();

        // ----------------------------------------
        // Retour de la vue
        // ----------------------------------------
        return view('dashboard', [
            'financeStats' => $financeStats,
            'stockStats' => $stockStats,
            'employeeDeptStats' => $employeeDeptStats,
            'activeEmployeesCount' => $activeEmployeesCount,
        ]);
    }
}
