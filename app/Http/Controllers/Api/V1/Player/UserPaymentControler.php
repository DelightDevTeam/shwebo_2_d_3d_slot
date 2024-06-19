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
        $data = UserPayment::where('user_id', Auth::id())->get();

        return $this->success($data, 'User Payment List');
    }

    public function create(PaymentTypeRequest $request)
    {
        try {
            $inputs = $request->validated();
            $params = array_merge($inputs, ['user_id' => Auth::id()]);

            $data = UserPayment::create($params);
        } catch (Exception $e) {
            $this->error('', $e->getMessage(), 401);
        }

        return $this->success($data, 'User Payment Create');
    }
}
