<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nom', 'url', 'tache_id'];

    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }
}
