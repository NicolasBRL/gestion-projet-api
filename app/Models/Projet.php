<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nom', 'description', 'date_debut', 'date_fin', 'avancement'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
