<?php

namespace Database\Seeders;

use App\Models\Admin\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'name' => 'CB Bank',
                'image' => 'cb.png',
                'agent_id' => 2,
                'bank_account_name' => 'Testing CBBank Account',
                'bank_account_no' => '1278767876767',
            ],
            [
                'name' => 'AYA Bank',
                'image' => 'aya.png',
                'agent_id' => 2,
                'bank_account_name' => 'Testing AYABank Account',
                'bank_account_no' => '1298789986678656',
            ],
            [
                'name' => 'KBZ Bank',
                'image' => 'kbz.png',
                'agent_id' => 2,
                'bank_account_name' => 'Testing KBZBanking Account',
                'bank_account_no' => '123456789878765',

            ],
            [
                'name' => 'KBZ Pay',
                'image' => 'kpay.png',
                'agent_id' => 2,
                'bank_account_name' => 'Testing KBZPay Account',
                'bank_account_no' => '09787676567',
            ],
            [
                'name' => 'Yoma Bank',
                'image' => 'yoma.png',
                'agent_id' => 2,
                'bank_account_name' => 'Testing YomaBank Account',
                'bank_account_no' => '09878767656',
            ],
        ];

        DB::table('banks')->insert($banks);

    }
}
