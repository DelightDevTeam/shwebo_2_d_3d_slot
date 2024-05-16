<?php

namespace App\Http\Controllers\Api\V1\Player;

use App\Enums\TransactionName;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use App\Services\WalletService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    use HttpResponses;

    public function index(Request $request)
    {
        $type = $request->get('type');

        [$from, $to] = match ($type) {
            'yesterday' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()],
            'this_week' => [now()->startOfWeek(), now()->endOfWeek()],
            'last_week' => [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()],
            default => [now()->startOfDay(), now()],
        };

        $user = auth()->user();

        $transactions = $user->transactions()->whereBetween('created_at', [$from, $to])
            ->orderBy('id', 'DESC')
            ->paginate();

        return $this->success(TransactionResource::collection($transactions));
    }

    public function exchangeBalance(Request $request)
    {
        $player = Auth::user();
        $inputs = $request->validate([
            'amount' => 'required',
        ]);

        if ($inputs['amount'] > $player->main_balance) {
            return $this->error('', 'You do not have enough balance to transfer', 201);
        }

        (new WalletService)->deposit($player, $inputs['amount'], TransactionName::CapitalDeposit);
        $player->main_balance -= $inputs['amount'];
        $player->save();

        return $this->success('', 'successfully exchange balance', 201);

    }
}
