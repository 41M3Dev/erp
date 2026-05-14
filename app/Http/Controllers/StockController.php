<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Fournisseur; // si besoin d'une liste de fournisseurs
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        // Récupère tous les produits en stock
        $stocks = Stock::all();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $fournisseurs = Fournisseur::all();
        return view('stocks.create', compact('fournisseurs'));
    }

    public function store(Request $request)
    {
        // Validez les champs requis
        $data = $request->validate([
            'id_fournisseur' => 'required|integer',
            'nom_produit' => 'required|string|max:150',
            'description' => 'nullable|string',
            'quantite' => 'required|integer',
            'seuil_alerte' => 'nullable|integer',
            'prix_achat' => 'nullable|numeric',
            'prix_vente' => 'nullable|numeric',
        ]);

        // Vous pouvez définir des valeurs par défaut si besoin
        // $data['date_creation'] = now(); // Par exemple

        Stock::create($data);

        return redirect()->route('stocks.index')
            ->with('success', 'Produit créé avec succès !');
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        $fournisseurs = Fournisseur::all();
        return view('stocks.edit', compact('stock', 'fournisseurs'));
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $data = $request->validate([
            'id_fournisseur' => 'nullable|integer|exists:fournisseurs,id_fournisseur',
            'nom_produit'    => 'required|string|max:150',
            'description'    => 'nullable|string',
            'quantite'       => 'required|integer',
            'seuil_alerte'   => 'nullable|integer',
            'prix_achat'     => 'nullable|numeric',
            'prix_vente'     => 'nullable|numeric',
        ]);

        $stock->update($data);

        return redirect()->route('stocks.index')
            ->with('success', 'Produit mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')
            ->with('success', 'Produit supprimé avec succès !');
    }
}
