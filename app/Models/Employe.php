<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $table = 'employes';
    
    protected $primaryKey = 'id_employe';

    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone', 'departement', 'date_embauche', 'date_debauche', 'actif'
    ];

    public $timestamps = false;

    public function salaires()
    {
        return $this->hasMany(Salaire::class, 'id_employe');
    }

    public function utilisateur()
    {
        return $this->hasOne(Utilisateur::class, 'id_employe', 'id_employe');
    }
    public function conges()
    {
        return $this->hasMany(Conge::class, 'id_employe', 'id_employe');
    }
}