<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
           'name' => 'Paco García',
           'email' => 'paco@test.com',
            'password' => bcrypt('1234'),
        ]);

        User::factory()->create([
            'name' => 'Pepe Garcia',
            'email' => 'pepe@test.com',
            'password' => bcrypt('1234'),
        ]);
    }
}
