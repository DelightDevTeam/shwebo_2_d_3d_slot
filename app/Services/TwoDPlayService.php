<?php

namespace App\Services;

use App\Helpers\SessionHelper;
use App\Models\TwoD\Lottery;
use App\Models\TwoD\LotteryTwoDigitPivot;
use App\Models\TwoD\TwoDigit;
use App\Models\TwoD\TwoDLimit;
use App\Models\TwoD\TwodSetting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TwoDPlayService
{
    public function play($totalAmount, array $amounts)
    {
        if (! Auth::check()) {
            return response()->json([
                'message' => 'You are not authenticated! please login.',
            ], 401);
        }

        $user = Auth::user();

        try {
            DB::beginTransaction();
            // Access `Limit` with error handling
            $limit = $user->limit ?? null;
            Log::info('user limit is '.$limit);
            if ($limit === null) {
                throw new \Exception("Commission rate 'limit' is not set for user.");
            }
            if ($user->main_balance < $totalAmount) {
                return 'Insufficient funds.';
            }
            $preOver = [];
            foreach ($amounts as $amount) {
                $preCheck = $this->preProcessAmountCheck($amount);
                if (is_array($preCheck)) {
                    $preOver[] = $preCheck[0];
                }
            }
            if (! empty($preOver)) {
                return $preOver;
            }

            // Create a new lottery entry
            $currentDate = Carbon::now()->format('Y-m-d'); // Format the date and time as needed
            $currentTime = Carbon::now()->format('H:i:s');
            $customString = 'shwebo-2d';
            $randomNumber = rand(1000, 9999); // Generate a random 4-digit number
            $slipNo = $randomNumber.'-'.$customString.'-'.$currentDate.'-'.$currentTime; // Combine date, string, and random number

            $lottery = Lottery::create([
                'pay_amount' => $totalAmount,
                'total_amount' => $totalAmount,
                'user_id' => $user->id,
                'slip_no' => $slipNo, // Add the generated slip_no here
            ]);

            $over = [];
            foreach ($amounts as $amount) {
                $check = $this->processAmount($amount, $lottery->id);
                if (is_array($check)) {
                    $over[] = $check[0];
                }
            }
            if (! empty($over)) {
                return $over;
            }
            /** @var \App\Models\User $user */
            $user->main_balance -= $totalAmount;

            $user->save();

            DB::commit();

            return 'Bet placed successfully.';

        } catch (ModelNotFoundException $e) {
            DB::rollback();
            Log::error('Model not found in TwoDService play method: '.$e->getMessage());

            return 'Resource not found.';
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in TwoDService play method: '.$e->getMessage());

            return $e->getMessage(); // Handle general exceptions
        }

    }

    protected function preProcessAmountCheck($amount)
    {
        $twoDigit = str_pad($amount['num'], 2, '0', STR_PAD_LEFT); // Ensure two-digit format
        $break = Auth::user()->limit ?? 0; // Set default value if `cor` is not set
        $user = Auth::user();
        $defaultBreak = TwoDLimit::lasted()->first();
        $user_default_break = $defaultBreak->two_d_limit;
        Log::info("User's commission limit (limit): {$break}");
        Log::info("Checking bet_digit: {$twoDigit}");
        Log::info("User's default break (default break): {$user_default_break}");

        $current_session = SessionHelper::getCurrentSession();
        $current_day = Carbon::now()->format('Y-m-d');

        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_pivots')
            ->where('res_date', $current_day)
            ->where('session', $current_session)
            ->where('bet_digit', $twoDigit)
            ->sum('sub_amount');

        Log::info("Total bet amount for {$twoDigit}: {$totalBetAmountForTwoDigit}");

        $subAmount = $amount['amount'];

        if ($totalBetAmountForTwoDigit + $subAmount > $user_default_break) {
            Log::info('not allow the bet');
        } else {
            if (isset($user->limit) && $totalBetAmountForTwoDigit + $subAmount < $user->limit) {
                return [$amount['num']];
            } else {
                Log::info('Within both limits, allow the bet');
            }
        }

        // if ($totalBetAmountForTwoDigit + $subAmount > $break) {
        //     Log::warning("Bet on {$twoDigit} exceeds limit.");

        //     return [$amount['num']]; // Indicates over-limit
        // }

        // Indicates no over-limit
    }

    protected function processAmount($amount, $lotteryId)
    {
        $twoDigits = TwoDigit::where('two_digit', sprintf('%02d', $amount['num']))->firstOrFail();
        $twoDigit = str_pad($amount['num'], 2, '0', STR_PAD_LEFT); // Ensure two-digit format

        $user = Auth::user();
        $break = $user->limit;
        $defaultBreak = TwoDLimit::lasted()->first();
        $user_default_break = $defaultBreak->two_d_limit;

        $current_session = SessionHelper::getCurrentSession();
        $current_day = Carbon::now()->format('Y-m-d');

        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_pivots')
            ->where('res_date', $current_day)
            ->where('session', $current_session)
            ->where('bet_digit', $twoDigit)
            ->sum('sub_amount');

        $subAmount = $amount['amount'];

        if (isset($user->limit) && $totalBetAmountForTwoDigit + $subAmount > $user->limit) {
            // User limit is set and exceeded, check default limit
            if ($totalBetAmountForTwoDigit + $subAmount > $user_default_break) {
                // Both limits exceeded, return error
                return [$amount['num']];
            } else {
                // User limit exceeded but within default limit, allow with warning
                Log::info('Bet exceeds user limit but falls within default limit.');
                // ... add logic to inform user and allow bet with default limit (optional) ...
            }
        } else {
            // Either no user limit is set or the bet doesn't exceed the user limit
            if ($totalBetAmountForTwoDigit + $subAmount > $user_default_break) {
                // Default limit exceeded, return error
                return [$amount['num']];
            } else {
                // Within both limits, allow the bet
                // ... existing code to check results, create lottery record, etc. ...
                $today = Carbon::now()->format('Y-m-d');
                // Retrieve results for today where status is 'open'
                $results = TwodSetting::where('result_date', $today) // Match today's date
                    ->where('status', 'open')      // Check if the status is 'open'
                    ->first();
                $play_date = Carbon::now()->format('Y-m-d');  // Correct date format
                $play_time = Carbon::now()->format('H:i:s');  // Correct time format
                $player_id = Auth::user();
                LotteryTwoDigitPivot::create([
                    'lottery_id' => $lotteryId,
                    'twod_setting_id' => $results->id,
                    'two_digit_id' => $twoDigits->id,
                    'user_id' => $player_id->id,
                    'bet_digit' => $amount['num'],
                    'sub_amount' => $subAmount,
                    'prize_sent' => false,
                    'match_status' => $results->status,
                    'res_date' => $results->result_date,
                    'res_time' => $results->result_time,
                    'session' => $current_session,
                    'admin_log' => $results->admin_log,
                    'user_log' => $results->user_log,
                    'play_date' => $play_date,
                    'play_time' => $play_time,
                ]);
            }
        }
    }

    // protected function processAmount($amount, $lotteryId)
    // {

    //     $twoDigits = TwoDigit::where('two_digit', sprintf('%02d', $amount['num']))->firstOrFail();
    //     $twoDigit = str_pad($amount['num'], 2, '0', STR_PAD_LEFT); // Ensure three-digit format

    //     $break = Auth::user()->limit;

    //     $current_session = SessionHelper::getCurrentSession();
    //     $current_day = Carbon::now()->format('Y-m-d');

    //     $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_pivots')
    //         ->where('res_date', $current_day)
    //         ->where('session', $current_session)
    //         ->where('bet_digit', $twoDigit)
    //         ->sum('sub_amount');
    //     $subAmount = $amount['amount'];
    //     $betDigit = $amount['num'];

    //     if ($totalBetAmountForTwoDigit + $subAmount <= $break) {
    //         $today = Carbon::now()->format('Y-m-d');
    //         // Retrieve results for today where status is 'open'
    //         $results = TwodSetting::where('result_date', $today) // Match today's date
    //             ->where('status', 'open')      // Check if the status is 'open'
    //             ->first();
    //         $play_date = Carbon::now()->format('Y-m-d');  // Correct date format
    //         $play_time = Carbon::now()->format('H:i:s');  // Correct time format
    //         $player_id = Auth::user();
    //         LotteryTwoDigitPivot::create([
    //             'lottery_id' => $lotteryId,
    //             'twod_setting_id' => $results->id,
    //             'two_digit_id' => $twoDigits->id,
    //             'user_id' => $player_id->id,
    //             'bet_digit' => $betDigit,
    //             'sub_amount' => $subAmount,
    //             'prize_sent' => false,
    //             'match_status' => $results->status,
    //             'res_date' => $results->result_date,
    //             'res_time' => $results->result_time,
    //             'session' => $current_session,
    //             'admin_log' => $results->admin_log,
    //             'user_log' => $results->user_log,
    //             'play_date' => $play_date,
    //             'play_time' => $play_time,

    //         ]);
    //     } else {
    //         // Handle the case where the bet exceeds the limit
    //         return [$amount['num']];
    //     }
    // }
}
