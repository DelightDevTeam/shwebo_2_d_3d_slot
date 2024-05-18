<?php

namespace App\Http\Controllers\Api\V1\Player;

use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\SeamlessTransactionResource;
use App\Http\Resources\WagerResource;
use App\Models\SeamlessTransaction;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WagerController extends Controller
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

        $transactions = SeamlessTransaction::leftJoin('products', 'products.id', '=', 'seamless_transactions.product_id')
            ->select(
                DB::raw('MIN(seamless_transactions.created_at) as from_date'),
                DB::raw('MAX(seamless_transactions.created_at) as to_date'),
                'products.name as product_name',
                'user_id',
                'product_id',
                DB::raw('COUNT(product_id) as total_count'),
                DB::raw('SUM(bet_amount) as total_bet_amount'),
                DB::raw('SUM(transaction_amount) as total_transaction_amount')
            )
            ->where('seamless_transactions.status', TransactionStatus::Settle->value)
            ->whereBetween('seamless_transactions.created_at', [$from, $to])
            ->where('user_id', $user->id)
            ->groupBy('user_id', 'product_id')
            ->orderBy('products.name')
            ->paginate();

        return $this->success(SeamlessTransactionResource::collection($transactions));
    }
}
