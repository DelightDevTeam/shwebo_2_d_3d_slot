<?php

namespace Database\Seeders;

use App\Models\Admin\Bank;
use Illuminate\Database\Seeder;

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
                'digit' => 13,
            ],
            [
                'name' => 'AYA Bank',
                'image' => 'aya.png',
                'digit' => 16,
            ],
            [
                'name' => 'KBZ Bank',
                'image' => 'kbz.png',
                'digit' => 17,
            ],
            [
                'name' => 'KBZ Pay',
                'image' => 'kpay.png',
                'digit' => 11,
            ],
            [
                'name' => 'Yoma Bank',
                'image' => 'yoma.png',
                'digit' => 16,
            ],
        ];

        foreach($banks as $bank)
        {
            Bank::create($bank);
        }
        // Bank::insert($bank);

    }
}
