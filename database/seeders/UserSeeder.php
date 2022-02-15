<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);

        User::factory()->create([
           'name' => 'Paco García',
           'email' => 'paco@test.com',
            'password' => bcrypt('1234'),
        ])->assignRole('admin');

        User::factory(100)->create();

        User::factory()->create([
            'name' => 'Pepe Garcia',
            'email' => 'pepe@test.com',
            'password' => bcrypt('1234'),
        ]);
    }
}
