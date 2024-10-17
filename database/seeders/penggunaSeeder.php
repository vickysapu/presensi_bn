<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class penggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penggunaData = [
            [
                'password' => 'KS00199',
                'username' => 'Kesiswaan'
            ],
        ];

        foreach($penggunaData as $data => $val) {
            User::create($val);
        }
    }
}
