<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Support\Facades\DB;

class StatistiqueEmployeController extends Controller
{
    public function index()
    {
        $parDepartement = Employe::select('departement', DB::raw('COUNT(*) as total'))
            ->groupBy('departement')
            ->get();

        $actifs   = Employe::where('actif', 1)->count();
        $inactifs = Employe::where('actif', 0)->count();

        return response()->json([
            'par_departement' => $parDepartement,
            'actifs'          => $actifs,
            'inactifs'        => $inactifs,
            'total'           => $actifs + $inactifs,
        ]);
    }
}
