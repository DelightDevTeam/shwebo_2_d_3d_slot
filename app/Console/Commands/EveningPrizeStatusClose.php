<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Helpers\SessionHelper;
use Illuminate\Console\Command;
use App\Models\TwoD\TwodSetting;
use App\Models\TwoD\TwodGameResult;
use Illuminate\Support\Facades\Log;
use App\Helpers\MorningSessionHelper;
use App\Helpers\MorningPrizeStatusHelper;
use App\Helpers\EveningPrizeStatusCloseHelper;
use App\Helpers\MorningPrizeStatusCloseHelper;

class EveningPrizeStatusClose extends Command
{
    protected $signature = 'session:evening-prize-status-close';

    protected $description = 'Update Evening session status based on time of day';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get current date and time in Asia/Yangon timezone
        $currentDateTime = Carbon::now()->setTimezone('Asia/Yangon');
        $currentDate = $currentDateTime->format('Y-m-d');
        $currentTime = $currentDateTime->format('H:i:s');
        // Get the current session
        $currentSession = EveningPrizeStatusCloseHelper::getCurrentSession();
        Log::info("Current Date && Time: {$currentDateTime}");
        Log::info("Current session: {$currentSession}");
        Log::info("Current date: {$currentDate}");
        Log::info("Current date: {$currentTime}");
        // Check if any 'open' session should be closed based on close_time
        TwodSetting::where('result_date', $currentDate)
            ->where('session', $currentSession)
            ->where('prize_status', 'open')
            ->update(['prize_status' => 'closed']);
        $this->info('Evening Session prize_status closed updated successfully for '.$currentSession.' session.');
    }
}
