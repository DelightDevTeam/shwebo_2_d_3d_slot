<?php

namespace App\Http\Controllers\Api\V1\PaymentType;

use App\Http\Controllers\Controller;
use App\Models\Admin\UserPayment;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class PaymentTypeController extends Controller
{
    use HttpResponses;

    public function all()
    {
        $player = Auth::user();

        $data = UserPayment::where('user_id', $player->agent_id)->get();

        return $this->success($data);
    }
}
