<?php

namespace App\Models\ThreeD;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\ThreeD\LotteryThreeDigitCopy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotteryThreeDigitPivot extends Model
{
    use HasFactory;
    protected $table = 'lottery_three_digit_pivots';

    protected $fillable = ['threed_setting_id', 'lotto_id', 'three_digit_id', 'user_id', 'bet_digit', 'sub_amount', 'prize_sent', 'match_status', 'res_date', 'res_time', 'match_start_date', 'result_number', 'play_date', 'play_time', 'admin_log', 'user_log'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // This will automatically boot with the model's events
    protected static function booted()
    {
        static::created(function ($pivot) {
            LotteryThreeDigitCopy::create($pivot->toArray());
        });
    }
}
