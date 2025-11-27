<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'election_id',
        'candidate_id',
        'voter_id',
    ];

    // Siapa yang memilih?
    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id');
    }

    // Memilih kandidat siapa?
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Di pemilihan apa?
    public function election()
    {
        return $this->belongsTo(Election::class);
    }
}
