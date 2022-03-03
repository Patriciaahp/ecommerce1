<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
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

    /** @test */
    public function categoryDetails_test()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);

        $subcategory = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Smartwatches',
                'slug' => Str::slug('Smartwatches'),
            ]);
        $brand = $category->brands()->create([
            'name' => 'marca1'
        ]);
        $product = Product::factory()->create([
            'name' => 'casa',
            'slug' => Str::slug('casa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 2]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/categories/celulares-y-tablets')
                ->pause(100)
                ->assertSee($product->name)
                ->assertSee($product->price)
                ->assertSee(ucfirst($product->brand->name))
                ->assertSee($product->subcategory->name)
                ->assertSee($product->subcategory->category->name)
                ->screenshot('categoryDetails');
        });
    }
}
