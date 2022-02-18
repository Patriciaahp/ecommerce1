<?php

namespace Tests\Browser;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CategoryTest extends DuskTestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    /** @test */
    public function categories()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Categorías')
                ->assertSee('Celulares')
                ->screenshot('categories');
        });
    }
}
