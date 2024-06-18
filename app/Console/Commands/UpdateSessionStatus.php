<?php
namespace App\Console\Commands;

use App\Helpers\SessionHelper;
use Illuminate\Console\Command;
use App\Models\TwoD\TwodSetting;

class UpdateSessionStatus extends Command
{
    protected $signature = 'session:update-status';
    protected $description = 'Update session status based on time of day';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentSession = SessionHelper::getCurrentSession();
        $status = ($currentSession == 'closed') ? 'closed' : 'open';

        TwodSetting::where('session', $currentSession)->update(['status' => $status]);
        $this->info('Session status updated successfully');
    }
}
