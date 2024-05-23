<?php

namespace App\Models\ThreeD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreedSetting extends Model
{
    use HasFactory;
     protected $fillable = ['result_date', 'result_time', 'result_number', 'status', 'admin_log', 'user_log', 'match_start_date', 'endpoint'];

    protected static function booted()
    {
        static::updated(function ($three_d_winner) {

            //CheckForThreeDWinners::dispatch($three_d_winner);
            //CheckForThreeDWinnersWithPermutations::dispatch($three_d_winner);

        });
    }
}
