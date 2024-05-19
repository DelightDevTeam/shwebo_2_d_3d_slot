<?php

namespace App\Http\Controllers\Api\V1\TwoD;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ApiEveningWinService;

class EveningWinPrizeController extends Controller
{
    protected $apiEveningWinService;

    public function __construct(ApiEveningWinService $apiEveningWinService)
    {
        $this->apiEveningWinService = $apiEveningWinService;
    }

    /**
     * Get morning prize sent data for the authenticated user.
     *
     * @return JsonResponse
     */
    public function getEveningPrizeSent(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $data = $this->apiEveningWinService->EveningPrizeSent();

        return response()->json([
            'status' => 'Request was successful.',
            'message' => null,
            'data' => $data,
        ]);
    }
}
