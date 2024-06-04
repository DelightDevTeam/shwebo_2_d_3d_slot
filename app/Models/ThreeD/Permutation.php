<?php

namespace App\Models\ThreeD;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\CheckForThreeDWinnersWithPermutations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permutation extends Model
{
    use HasFactory;

    protected $fillable = ['digit'];
    protected static function booted()
    {
        static::created(function ($prize) {
            CheckForThreeDWinnersWithPermutations::dispatch($prize);
        });
    }
}
