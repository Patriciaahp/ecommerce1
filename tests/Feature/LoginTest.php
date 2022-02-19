<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Str;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
/** @test */
    public function example_test()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /** @test */
    public function login_test()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
      $this->get('/')
          ->assertSee('Login')
        ->assertSee('Registro')
      ->assertDontSee('Logout');
    }
    /** @test */
    public function registeredUserLogin_test()
    {
      $user =  User::factory()->create([
            'name' => 'Paco García',
            'email' => 'paco@test.com',
            'password' => bcrypt('1234'),
        ]);

        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $this->actingAs($user)->get('/')
            ->assertSee('Logout')
            ->assertSee('Perfil')
            ->assertSee('Mis Pedidos')
            ->assertDontSee('Login');
    }

}
