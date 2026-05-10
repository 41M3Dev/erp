<?php
// app/Http/Controllers/EmployeController.php
namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function create()
    {
        $employes = Employe::orderBy('date_embauche', 'desc')->limit(15)->get();
        return view('employes.create', compact('employes'));
    }
    public function index()
    {
        $employes = Employe::all();
        return view('employes.index', compact('employes'));
    }
    public function store(Request $request)
    {
        $messages = [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L’email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'departement.required' => 'Veuillez choisir un département.',
            'telephone.required' => 'Le numéro est obligatoire.',
            'telephone.unique' => 'Le numéro est déjà utilisé.',
            'date_embauche.required' => 'La date d’embauche doit être une date valide.'
        ];
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employes,email',
            'departement' => 'required|in:rh,finance,informatique,livraison,employe',
            'telephone' => 'required|string|max:20|unique:employes,telephone',
            'date_embauche' => 'required|date',
        ], $messages);
        $employe = new Employe();
        $employe->nom = $request->nom;
        $employe->prenom = $request->prenom;
        $employe->email = $request->email;
        $employe->telephone = $request->telephone;
        $employe->date_embauche = $request->date_embauche;
        $employe->departement = $request->departement;
        $employe->save();
        return redirect()->route('employes.index')->with('success', 'Employé ajouté avec succès.');

    }

    public function edit($id)
    {
        // Récupérer l'employé à modifier
        $employe = Employe::findOrFail($id);
        // (Optionnel) Récupérer la liste des employés pour afficher la liste à côté du formulaire
        $employes = Employe::all();

        // Retourner la vue d'édition en passant l'employé (et la liste si besoin)
        return view('employes.edit', compact('employe', 'employes'));
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'departement' => 'required|string',
            'date_embauche' => 'required|date',
            'date_debauche' => 'nullable|date|after_or_equal:date_embauche',
        ]);

        // Trouver l'employé
        $employe = Employe::findOrFail($id);

        // Préparer les données pour la mise à jour
        $data = $request->only([
            'nom',
            'prenom',
            'email',
            'departement',
            'date_embauche',
            'date_debauche'
        ]);

        // Mettre à jour 'actif' en fonction de 'date_debauche'
        $data['actif'] = $request->filled('date_debauche') ? 0 : 1;

        // Mettre à jour l'employé
        $updated = $employe->update($data);

        // Vérifier si la mise à jour a réussi
        if ($updated) {
            return redirect()->route('employes.index')->with('success', 'Employé mis à jour avec succès.');
        } else {
            return redirect()->route('employes.index')->with('error', 'Erreur lors de la mise à jour de l\'employé.');
        }
    }
}