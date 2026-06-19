<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modul extends Model
{
    protected $fillable = ['nom', 'abreviatura'];

    /**
     * Cicles als quals pertany aquest modul.
     */
    public function cicles(): BelongsToMany
    {
        return $this->belongsToMany(Cicle::class, 'cicle_modul');
    }
}
