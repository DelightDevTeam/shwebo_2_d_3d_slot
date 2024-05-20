<?php

namespace App\Http\Controllers\Admin\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TwoD\LotteryTwoDigitCopy;

class TwoDManageController extends Controller
{
    public function SessionReset()
    {
        LotteryTwoDigitCopy::truncate();
        session()->flash('SuccessRequest', 'Successfully 2D Session Reset.');

        return redirect()->back()->with('message', 'Data reset successfully!');
    }

}
