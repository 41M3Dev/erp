<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use Illuminate\Http\Request;

class CongeController extends Controller
{
    public function approval()
    {
        $conges = Conge::with('employe')->get();
        return view('conges.index', compact('conges'));
    }

    public function approveLeave(Request $request, $id)
    {
        $conge = Conge::findOrFail($id);
        $conge->statut = 'Validé';
        $conge->save();

        return redirect()->route('conges.index')->with('success', 'Demande de congé approuvée avec succès.');
    }

    public function rejectLeave(Request $request, $id)
    {
        $conge = Conge::findOrFail($id);
        $conge->statut = 'Annulé';
        $conge->save();

        return redirect()->route('conges.index')->with('success', 'Demande de congé refusée avec succès.');
    }

    public function view_leave_request()
    {
        return view('conges.create');
    }

    public function leave_request(Request $request)
    {
        $employe = auth()->user()->employe;

        if (!$employe) {
            return redirect()->back()->with('error', 'Votre compte n\'est pas lié à un employé.');
        }

        $request->validate([
            'type_conge' => 'required|in:RTT,CP,Maladie',
            'date_debut'  => 'required|date',
            'date_fin'    => 'required|date|after_or_equal:date_debut',
        ]);

        $conge = new Conge();
        $conge->id_employe   = $employe->id_employe;
        $conge->type_conge   = $request->type_conge;
        $conge->date_debut   = $request->date_debut;
        $conge->date_fin     = $request->date_fin;
        $conge->commentaires = $request->raison;
        $conge->statut       = 'En attente';
        $conge->save();

        return redirect()->route('user.dashboard')->with('success', 'Demande de congé enregistrée avec succès !');
    }
}