<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tutor extends Model
{
    protected $fillable = ['user_id', 'curs'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alumnes assignats a aquest tutor.
     */
    public function alumnes(): BelongsToMany
    {
        return $this->belongsToMany(Alumne::class, 'tutor_alumne');
    }
}
