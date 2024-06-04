<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LiveChat\Chat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::where('id', '1')->first();
        $user = User::where('id', '3')->first(); // Adjust as per your user type

        Chat::create([
            'user_id' => $user->id,
            'admin_id' => $admin->id,
        ]);
    }
}
