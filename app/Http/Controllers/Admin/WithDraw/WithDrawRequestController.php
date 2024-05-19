<?php

namespace App\Http\Controllers\Admin\WithDraw;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithDrawRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithDrawRequestController extends Controller
{
    public function index()
    {
        $withdraws = WithDrawRequest::with(['user', 'bank'])->orderby('id','desc')->get();

        return view('admin.withdraw_request.index', compact('withdraws'));
    }

    public function show($id)
    {
        $withdraw = WithDrawRequest::find($id);

        return view('admin.withdraw_request.show', compact('withdraw'));
    }

    public function statusChange(Request $request, WithDrawRequest $withdraw)
    {

        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);

        try {
            $agent = Auth::user();
            $player = User::find($request->player);
            if ($agent->main_balance < $request->amount) {
                return redirect()->back()->with('error', 'You do not have enough balance to transfer!');
            }

            $withdraw->update([
                'status' => $request->status,
            ]);
            if ($request->status == 1) {

                $agent->main_balance += $request->amount;
                $agent->save();

                $player->main_balance -= $request->amount;
                $player->save();
            }

            return back()->with('success', 'Withdraw request successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
