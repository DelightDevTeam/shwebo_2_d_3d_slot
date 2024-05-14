<?php

namespace Database\Seeders;

use App\Models\ThreeDigit\ThreeDLimit;
use App\Models\TwoD\TwoDLimit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TwoDBreakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TwoDLimit::create(['two_d_limit' => '500']);
        //ThreeDLimit::create(['three_d_limit' => '500']);
    }
}
