<?php

namespace App\Http\Controllers\Api\V1\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DepositRequest as ApiDepositRequest;
use App\Models\DepositRequest;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    use HttpResponses;

    public function deposit(ApiDepositRequest $request)
    {
        try {
            $inputs = $request->validated();
          
            $player = Auth::user();

            if ($player->main_balance < $inputs['amount']) {
                return $this->error('', 'Insuffience Balance', 401);
            }
            $params = array_merge($inputs, ['user_id' => $player->id]);
            
            $deposit = DepositRequest::create($params);
           
            return $this->success($deposit, 'Deposit Request Success');
        } catch (Exception $e) {
            $this->error('', $e->getMessage(), 401);
        }
    }
}
