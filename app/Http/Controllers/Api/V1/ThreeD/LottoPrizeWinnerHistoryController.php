<?php

namespace App\Http\Controllers\Api\V1\ThreeD;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LottoPrizeWinnerHistoryController extends Controller
{
    public function FirstPrizeWinnerApi()
{
    $user_id = Auth()->id();
    $reports = DB::table('lottery_three_digit_pivots')
        ->select('running_match', DB::raw('COUNT(*) as total_records'), DB::raw('SUM(sub_amount) as total_amount'))
        ->where('user_id', $user_id) // Filter where user id is auth id
        ->where('prize_sent', true) // Filter where prize_sent is true
        ->groupBy('running_match')
        ->orderByDesc('running_match') // Optional: order by running_match descending
        ->get();

    return response()->json([
        'success' => true,
        'message' => 'Data retrieved successfully.',
        'data' => $reports
    ]);
}

}
