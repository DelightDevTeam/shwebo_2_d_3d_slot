<?php

namespace App\Http\Controllers\Api\V1\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentTypeRequest;
use App\Models\Admin\UserPayment;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPaymentControler extends Controller
{
    use HttpResponses;
    
    public function index()
    {
        $data = UserPayment::with('paymentType')->where('user_id', Auth::id())->get();
        
        return $this->success($data, 'User Payment List');
    }

    public function create(PaymentTypeRequest $request)
    {
            $inputs = $request->validated();
            $params = array_merge($inputs, ['user_id' => Auth::id()]);
            $data = UserPayment::where('user_id', Auth::id())->first();
          
            if($data)
            {
                return $this->error('', 'Already Exist Account', 401);
            }

            $data = UserPayment::create($params);

        return $this->success($data, 'User Payment Create');
    }

    public function agentPayment()
    {
        $player = Auth::user();

        $data = UserPayment::with('paymentType', 'paymentType.paymentImages')->where('user_id', $player->agent_id)->get();

        return $this->success($data, 'User Payment List');

    }
}
