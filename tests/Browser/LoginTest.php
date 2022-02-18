<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;

    /** @test */
    public function login()
    {
        $user =  User::factory()->create([
            'name' => 'Paco García',
            'email' => 'paco@test.com',
            'password' => bcrypt('1234')]);
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $this->browse(function ($browser) {
            //We'll test the register feature here
            $browser
                ->visit('/')
                ->click('.fa-user-circle')
                ->pause(10)
                ->clickLink('Login')
                ->value('#email', 'paco@test.com')
                ->value('#password', '1234')
                ->press('INICIAR SESIÓN')
                ->assertPathIs('/dashboard')
                ->screenshot('login');


        });
    }
}
