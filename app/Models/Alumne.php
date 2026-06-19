<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alumne extends Model
{
    protected $fillable = ['user_id', 'numero_seguretat_social'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Professors assignats a aquest alumne.
     */
    public function professors(): BelongsToMany
    {
        return $this->belongsToMany(Professor::class, 'professor_alumne');
    }

    /**
     * Tutors assignats a aquest alumne.
     */
    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(Tutor::class, 'tutor_alumne');
    }
}
