<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conge extends Model
{
    public $timestamps = false; // Désactive `created_at` et `updated_at`

    use HasFactory;

    protected $table = 'conges';
    protected $primaryKey = 'id_conge';
    protected $fillable = ['id_employe', 'type_conge', 'date_debut', 'date_fin', 'statut', 'commentaires'];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe', 'id_employe');
    }
}
