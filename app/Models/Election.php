<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    // Relasi: Satu pemilihan punya banyak kandidat
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    // Relasi: Satu pemilihan punya banyak suara masuk
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
