<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;
    // Renseigner les champs créés dans les migrations
    // pour éviter "l'exception d'affectation en masse"
    protected $fillable = ['name', 'description', 'price', 'photo'];

    
    // Faire les clés étrangères pour affichage des annonces :
    public function userAnnonce() {
        return $this->belongsTo(User::class, 'user_id');
    }

    


}
