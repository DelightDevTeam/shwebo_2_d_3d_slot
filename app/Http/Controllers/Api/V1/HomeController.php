<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin\Banner;
use App\Models\Admin\BannerText;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use HttpResponses;
    public function home()
    {
        $banners = Banner::all();
        $bannerText = BannerText::latest()->first();
        return $this->success([
            'banners' => $banners,
            'bannerText' => $bannerText
        ]);
    }
}
