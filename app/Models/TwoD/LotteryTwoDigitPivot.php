<?php

namespace App\Models\TwoD;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\TwoD\LotteryTwoDigitCopy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotteryTwoDigitPivot extends Model
{
    use HasFactory;
    protected $table = 'lottery_two_digit_pivots';

    protected $fillable = ['lottery_id', 'twod_game_result_id', 'two_digit_id',  'user_id', 'bet_digit', 'sub_amount', 'prize_sent', 'match_status', 'res_date', 'res_time', 'session', 'admin_log', 'user_log', 'play_date', 'play_time'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::created(function ($pivot) {
            LotteryTwoDigitCopy::create($pivot->toArray());
        });
    }
}
