<?php

namespace Tests\Feature;

use App\Models\Category;

use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function product_test()
    {
         Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);

        $this->get('/')
            ->assertSee('Categorías')
            ->assertSee('Celulares y tablets');
    }
    /** @test */
    public function sizeAndColor_test()
    {
        $category = Category::factory()->create(['name' => 'Moda', 'slug' => Str::slug('Moda'),
            'icon' => '<i class="fas fa-tshirt"></i>'
        ]);

        $subcategory = Subcategory::create([
            'category_id' => 1,
            'name' => 'Hombres',
            'slug' => Str::slug('Hombres'),
            'color' => true, 'size' => true
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
            'quantity' => 2,
            'status' => 2,
        ]);
        $product->images()->create([
            'url' => 'storage/aaa.png'
        ]);
        Color::create(['name' => 'Blanco',]);
        Color::create(['name' => 'Negro',]);
        $product->colors()->attach([1 => ['quantity' => 10],
            2 => ['quantity' => 6]]);

        $size =   Size::create(['name' => 'M',
            'product_id' => $product->id]);

        $size->colors()->attach([1=>['quantity' => 10],
            2=>['quantity' => 10]]);

        $this->get('/products/' . $product->id)
            ->assertSeeLivewire('add-cart-item-size');



    }



}
