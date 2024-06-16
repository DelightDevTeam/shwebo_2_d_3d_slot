<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Kpay Account',
                'image' => 'kpay.png'
            ],
            [
                'name' => 'Wave Account',
                'image' => 'wave.png'
            ]
        ];

        DB::table('payment_types')->insert($data);

    }
}
