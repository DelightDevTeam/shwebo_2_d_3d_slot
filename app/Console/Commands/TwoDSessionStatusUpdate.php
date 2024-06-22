<?php

namespace App\Console\Commands;

use App\Helpers\TwoDSessionHelper;
use App\Models\TwoD\TwodSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TwoDSessionStatusUpdate extends Command
{
    protected $signature = 'session:twod-update-status';

    protected $description = 'Update session status based on time of day';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentSession = TwoDSessionHelper::getCurrentSession();
        $status = ($currentSession == 'closed') ? 'closed' : 'open';

        // Get current date and next date in Asia/Yangon timezone
        $currentDate = Carbon::now('Asia/Yangon')->format('Y-m-d');
        $nextDate = Carbon::now('Asia/Yangon')->addDay()->format('Y-m-d');

        // Update only next day's morning sessions if the session is morning
        if ($currentSession == 'morning') {
            TwodSetting::where('result_date', $nextDate)
                ->where('session', 'morning')
                ->update(['status' => $status]);
        }

        // Update only today's evening sessions if the session is evening
        if ($currentSession == 'evening') {
            TwodSetting::where('result_date', $currentDate)
                ->where('session', 'evening')
                ->update(['status' => $status]);
        }

        $this->info('Session status updated successfully for '.$currentSession.' session.');
    }
}
