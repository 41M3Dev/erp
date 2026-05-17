<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::all();
        return view('commandes.index', compact('commandes'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all();

        $statuts = ['En cours', 'Livré', 'Annulé'];

        return view('commandes.create', compact('fournisseurs', 'statuts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference_commande' => 'required|string|max:100',
            'id_fournisseur'     => 'nullable|integer|exists:fournisseurs,id_fournisseur',
            'destinataire'       => 'nullable|string|max:255',
            'statut_livraison'   => 'required|in:En cours,Livré,Annulé',
            'date_livraison'     => 'nullable|date',
        ]);

        Commande::create($data);

        return redirect()->route('commandes.index')
            ->with('success', 'Commande créée avec succès !');
    }



    public function edit($id)
    {
        $commande = Commande::findOrFail($id);
        $fournisseurs = Fournisseur::all();
        $statuts = ['En cours', 'Livré', 'Annulé'];

        return view('commandes.edit', compact('commande', 'fournisseurs', 'statuts'));
    }

    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);

        $data = $request->validate([
            'reference_commande' => 'required|string|max:100',
            'id_fournisseur'     => 'nullable|integer|exists:fournisseurs,id_fournisseur',
            'statut_livraison'   => 'required|in:En cours,Livré,Annulé',
            'date_livraison'     => 'nullable|date',
        ]);

        $commande->update($data);

        return redirect()->route('commandes.index')
            ->with('success', 'Commande mise à jour avec succès !');
    }

    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        return redirect()->route('commandes.index')
            ->with('success', 'Commande supprimée avec succès !');
    }
}
