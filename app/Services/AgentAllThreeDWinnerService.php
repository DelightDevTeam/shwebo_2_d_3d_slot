<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\ThreeD\ThreedSetting;
use Illuminate\Support\Facades\Auth;
use App\Models\ThreeD\LotteryThreeDigitPivot;

class AgentAllThreeDWinnerService
{
    public function AgentAllWinner()
    {
        $agent_id = Auth::user();
        
     
        $records = LotteryThreeDigitPivot::with('user')
            ->where('agent_id', $agent_id->id)
            ->where('prize_sent', true)
            ->get();

        // Calculate the total sub_amount
        $total_sub_amount = $records->sum('sub_amount');

        // Return the records and total sub_amount
        return [
            'records' => $records,
            'total_sub_amount' => $total_sub_amount,
        ];
    }
}
