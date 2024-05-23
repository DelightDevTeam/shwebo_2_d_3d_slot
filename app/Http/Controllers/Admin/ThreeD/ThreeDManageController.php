<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Illuminate\Http\Request;
use App\Models\ThreeD\ThreedClose;
use App\Models\ThreeD\ThreeDLimit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\ThreeD\LotteryThreeDigitCopy;

class ThreeDManageController extends Controller
{
    public function index()
    {
        $digits = ThreedClose::all();

        return view('admin.three_d.close_digit.index', compact('digits'));
    }
    public function ThreeDReset()
    {
        LotteryThreeDigitCopy::truncate();
        //Permutation::truncate();
        //Prize::truncate();
        session()->flash('SuccessRequest', 'Successfully 3D Reset.');

        return redirect()->back()->with('message', 'Data reset successfully!');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'digit' => 'required|numeric',
            ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        // store
        ThreedClose::create([
            'digit' => $request->digit,
        ]);

        return redirect()->route('admin.ThreedCloseIndex')->with('toast_success', 'CloseThreeDigit created successfully.');

    }

    public function destroy($id)
    {
        $limit = ThreedClose::findOrFail($id);
        $limit->delete();

        return redirect()->route('admin.ThreedCloseIndex')->with('toast_success', 'CloseThreeDigit deleted successfully.');
    }


    public function ThreedDefaultLimitindex()
    {
        $limits = ThreeDLimit::all();

        return view('admin.three_d.limit.index', compact('limits'));
    }

    public function ThreedLimitstore(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'three_d_limit' => 'required',

            //'body' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        // store
        ThreeDLimit::create([
            'three_d_limit' => $request->three_d_limit,
        ]);

        // redirect
        return redirect()->route('admin.ThreeddefaultLimitIndex')->with('toast_success', 'three d limit created successfully.');
    }

    public function ThreedLimitdestroy($id)
    {
        $limit = ThreeDLimit::findOrFail($id);
        $limit->delete();

        return redirect()->route('admin.ThreeddefaultLimitIndex')->with('toast_success', 'Limit deleted successfully.');
    }


}
