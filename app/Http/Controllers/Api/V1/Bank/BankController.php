<?php

namespace App\Http\Controllers\Api\V1\Bank;

use App\Http\Controllers\Controller;
use App\Models\Admin\Bank;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    use HttpResponses;

    public function all()
    {
        $player = Auth::user();

        $data = Bank::where('agent_id', $player->agent_id)->get();

        return $this->success($data);
    }
}
