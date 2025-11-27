<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'name',
        'photo',
        'vision_mission',
        'total_votes',
    ];

    // Relasi: Kandidat milik satu pemilihan
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    // Relasi: Kandidat punya banyak suara
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
