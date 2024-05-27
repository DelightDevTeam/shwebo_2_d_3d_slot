<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LottoOneWeekRecordService;

class OneWeekRecordController extends Controller
{
    protected $lottoService;

    public function __construct(LottoOneWeekRecordService $lottoService)
    {
        $this->lottoService = $lottoService;
    }

    public function showRecordsForOneWeek()
    {
        $data = $this->lottoService->GetRecordForOneWeek();

        return view('admin.three_d.records.one_week_rec', compact('data'));
    }
}
