<?php

namespace Tests\Feature;

use App\Models\Category;

use App\Models\Image;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Str;
use Tests\TestCase;

class DetailViewTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function getDetailViewProduct_test()
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
            'quantity' => 12,
            'status' => 2]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);

        $this
             ->get('/products/1')
            ->assertSee($product->brand->name)
            ->assertSee($product->subcategory->name)
            ->assertSee($product->description)
            ->assertSee($product->price)

            ->assertSee('Se hacen envíos solo a la península');

    }



}
