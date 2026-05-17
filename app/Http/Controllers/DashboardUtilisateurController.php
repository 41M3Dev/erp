<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;
use App\Models\Employe;

class DashboardUtilisateurController extends Controller
{

    public function index()
    {
        $utilisateur = auth()->user();


        $employe = $utilisateur->employe;

        if (!$employe) {
            return redirect()->route('dashboard')->with('error', "Votre compte n'est pas lié à un dossier employé. Contactez l'administrateur.");
        }

        $conges = $employe->conges()->get();
        //$conges = $employe->conges();

        // Récupérer les salaires de l'employé
        $salaires = $employe->salaires()->get();

        return view('user.index', compact('conges', 'salaires'));
    }
    public function edit($id)
    {
        $user = auth()->user(); // ou Utilisateur::findOrFail($id);
        return view('user.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $utilisateur = auth()->user();

        $utilisateur->username = $request->input('username');
        $utilisateur->email = $request->input('email');
        if ($request->filled('password')) {
            $utilisateur->password = $request->input('password');
        }
        $utilisateur->save();
        return redirect()->route('user.dashboard')->with('success', 'Profil mis à jour avec succès');
    }
}