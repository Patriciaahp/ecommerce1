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

class FilterTest extends DuskTestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    /** @test */
    public function ProductFilter_test()
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
            'name' => 'marca'
        ]);
        $product = Product::factory()->create([
            'name' => 'casa',
            'slug' => Str::slug('casa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 1,
            'status' => 2]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $product2 = Product::factory()->create([
            'name' => 'botella',
            'slug' => Str::slug('botella'),
            'description' => 'botella de metal',
            'price' => 19.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 1,
            'status' => 2]);
        $product2->images()->create([
            'url' => 'storage/enrf3.png'
        ]);

        $product3 = Product::factory()->create([
            'name' => 'queso',
            'slug' => Str::slug('queso'),
            'description' => 'queso azul',
            'price' => 9.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 1,
            'status' => 2]);
        $product3->images()->create([
            'url' => 'storage/enrf3.png'
        ]);

        $product4 = Product::factory()->create([
            'name' => 'pollo',
            'slug' => Str::slug('pollo'),
            'description' => 'pollo asado',
            'price' => 2.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 1,
            'status' => 2]);
        $product4->images()->create([
            'url' => 'storage/enrf3.png'
        ]);

        $this->browse(function (Browser $browser) use ($product, $product2, $product3, $product4) {
            $browser->visit('/' )
                -> pause(2000)
               ->type('input', 'a')
                -> pause(2000)
                ->assertSeeIn('.space-y-1', $product->name)
                ->assertSeeIn('.space-y-1', $product2->name)
                ->assertDontSeeIn('.space-y-1', $product3->name)
                ->assertDontSeeIn('.space-y-1', $product4->name)
                ->screenshot('ProductFilter');


        });
    }

}
