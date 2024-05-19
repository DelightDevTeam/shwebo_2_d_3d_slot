<?php

namespace App\Http\Controllers\Admin\Deposit;

use App\Http\Controllers\Controller;
use App\Models\DepositRequest;
use App\Models\User;
use App\Models\WithDrawRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositRequestController extends Controller
{
    public function index()
    {
        $deposits = DepositRequest::with(['user', 'bank'])->where('agent_id', Auth::id())->orderBy('id', 'desc')->get();

        return view('admin.deposit_request.index', compact('deposits'));
    }

    public function show($id)
    {
        $deposit = DepositRequest::find($id);

        return view('admin.deposit_request.show', compact('deposit'));
    }

    public function updateStatus(Request $request, DepositRequest $deposit)
    {

        $request->validate([
            'status' => 'required|in:0,1,2|integer',
        ]);

        try {
            $agent = Auth::user();
            $player = User::find($request->player);
            if ($agent->main_balance < $request->amount) {
                return redirect()->back()->with('error', 'You do not have enough balance to transfer!');
            }

            $deposit->update([
                'status' => $request->status,
            ]);

            if ($request->status == 1) {

                $agent->main_balance -= $request->amount;
                $agent->save();

                $player->main_balance += $request->amount;
                $player->save();
            }

            return back()->with('success', 'Deposit request successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
