<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cicle extends Model
{
    protected $fillable = ['nom', 'abreviatura'];

    /**
     * Moduls assignats a aquest cicle.
     */
    public function moduls(): BelongsToMany
    {
        return $this->belongsToMany(Modul::class, 'cicle_modul');
    }
}
