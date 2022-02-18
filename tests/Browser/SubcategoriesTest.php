<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SubcategoriesTest extends DuskTestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    /** @test */
    public function categories()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);

        $subcategories =  Subcategory::create(
            ['category_id' => 1,
                'name' => 'Smartwatches',
                'slug' => Str::slug('Smartwatches'),
            ]);
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Categorías')
                ->pause(100)
                ->assertSee('Celulares y tablets')
                ->assertSee('Smartwatches')
                ->screenshot('subcategories');
        });
    }
}
