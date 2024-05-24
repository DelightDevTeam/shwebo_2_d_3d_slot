<?php

namespace App\Http\Controllers\Api\V1\ThreeD;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Helpers\DrawDateHelper;
use App\Models\ThreeD\ThreeDigit;
use App\Models\ThreeD\ThreedClose;
use App\Models\ThreeD\ThreeDLimit;
use App\Services\LottoPlayService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ThreeD\ThreedSetting;
use Illuminate\Support\Facades\Auth;
use App\Models\ThreeD\LotteryThreeDigitCopy;
use App\Http\Requests\ThreeD\ThreedPlayRequest;

class PlayController extends Controller
{
    use HttpResponses;

    protected $playService;

    public function get_threedigit()
    {
        $digits = ThreeDigit::all();

        $over_all_break = ThreeDLimit::latest()->first()->three_d_limit;
        $user = Auth::user();
        $user_break = $user->limit;

        foreach ($digits as $digit) {
            $totalAmount = LotteryThreeDigitCopy::where('three_digit_id', $digit->id)->sum('sub_amount');
            $over_all_remaining = $over_all_break - $totalAmount;
            $digit->over_all_remaining = $over_all_remaining;
            $user_remaining = $user_break - $totalAmount;
            $digit->user_remaining = $user_remaining;
        }

        return $this->success([
            'three_digits' => $digits,
            'break' => $over_all_break,
            'user_break' => $user_break,
        ]);
    }

    public function store(ThreedPlayRequest $request, LottoPlayService $playService)
{
    Log::info('Store method called.');

    $currentDate = ThreedSetting::where('status', 'open')->first();

    if (!$currentDate || $currentDate->status === 'closed') {
        return response()->json([
            'success' => false,
            'message' => 'This 3D lottery match is closed for at this time. Welcome back Next Time!',
        ], 401);
    }

    $draw_date = DrawDateHelper::getResultDate();
    $start_date = $draw_date['match_start_date'];
    $end_date = $draw_date['result_date'];

    Log::info("Start Date: {$start_date}, End Date: {$end_date}");

    Log::info($request->all());
    $totalAmount = $request->input('totalAmount');
    $amounts = $request->input('amounts');

    $closedTwoDigits = ThreedClose::query()
        ->pluck('digit')
        ->map(function ($digit) {
            return sprintf('%03d', $digit);
        })
        ->unique()
        ->filter()
        ->values()
        ->all();

    foreach ($amounts as $amount) {
        $twoDigitOfSelected = sprintf('%03d', $amount['num']);
        if (in_array($twoDigitOfSelected, $closedTwoDigits)) {
            return response()->json(['message' => "3D -  '{$twoDigitOfSelected}'  ကိုပိတ်ထားသောကြောင့် ကံစမ်း၍ မရနိုင်ပါ ၊ ကျေးဇူးပြု၍ ဂဏန်းပြန်ရွှေးချယ်ပါ။ "], 401);
        }
    }

    $result = $playService->play($totalAmount, $amounts);

    if ($result == "Insufficient funds.") {
        $message = "လက်ကျန်ငွေ မလုံလောက်ပါ။";
    } elseif (is_array($result)) {
        $digit = [];
        foreach ($result as $r) {
            $digit[] = ThreeDigit::find($r)->three_digit;
        }
        $d = implode(",", $digit);
        $message = "{$d} ဂဏန်းမှာ သတ်မှတ် Limit ထက်ကျော်လွန်နေပါသည်။";
    } else {
        return $this->success($result);
    }

    return response()->json(['message' => $message], 401);
}

}
