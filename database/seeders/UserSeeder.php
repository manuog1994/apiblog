<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Manuel Ortega Galiano',
            'email' => 'manuel@trivicare.com',
            'password' => bcrypt('12345678'),
        ]);

        User::factory(49)->create();
    }
}
