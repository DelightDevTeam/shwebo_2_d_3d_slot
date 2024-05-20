<?php

namespace App\Http\Controllers\Admin\ThreeD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThreeDManageController extends Controller
{
    public function ThreeDReset()
    {
        LotteryThreeDigitCopy::truncate();
        //Permutation::truncate();
        //Prize::truncate();
        session()->flash('SuccessRequest', 'Successfully 3D Reset.');

        return redirect()->back()->with('message', 'Data reset successfully!');
    }
}
