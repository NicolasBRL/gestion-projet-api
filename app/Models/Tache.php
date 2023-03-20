<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nom', 'description', 'date_debut', 'date_fin', 'avancement'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
