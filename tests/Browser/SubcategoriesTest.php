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

    /** @test */
    public function subcategoryFilter_test()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $subcategory = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Smartwatches',
                'slug' => Str::slug('Smartwatches'),
            ]);

        $brand1 = $category->brands()->create([
            'name' => 'marca2'
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

        $subcategory1 = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Accesorios para celulares',
                'slug' => Str::slug('Accesorios para celulares'),
            ]);
        $brand = $category->brands()->create([
            'name' => 'marca1'
        ]);
        $product1 = Product::factory()->create([
            'name' => 'coche',
            'slug' => Str::slug('coche'),
            'description' => 'la coche asdd',
            'price' => 39.99,
            'subcategory_id' => 2,
            'brand_id' => 2,
            'quantity' => 13,
            'status' => 2]);
        $product1->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $this->browse(function (Browser $browser) use (
            $product1, $subcategory1, $product, $category, $brand,
            $subcategory
        ) {
            $browser->visit('/')
                ->clickLink('Categorías')
                ->pause(100)
                ->clickLink($subcategory->name)
                ->assertSee($product->name)
                ->assertSee(ucfirst($product->brand->name))
                ->clickLink($subcategory1->name)
                ->pause(100)
                ->assertSee($product1->name)
                ->assertSee(ucfirst($product1->brand->name))
                ->screenshot('subcategoryFilter');
        });
    }

}
