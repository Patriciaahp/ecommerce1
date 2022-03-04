<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestHelpers;

class ProductsTest extends DuskTestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use TestHelpers;

    /** @test */
    public function product_test()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);

        $subcategory = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Smartwatches',
                'slug' => Str::slug('Smartwatches'),
            ]);
        $category->brands()->create([
            'name' => 'loqsea'
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
        $product1 = Product::factory()->create([
            'name' => 'casaaaa',
            'slug' => Str::slug('casaaaa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 2]);
        $product1->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $product2 = Product::factory()->create([
            'name' => 'coche',
            'slug' => Str::slug('coche'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 2]);
        $product2->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $product3 = Product::factory()->create([
            'name' => 'casaa',
            'slug' => Str::slug('casaa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 2]);
        $product3->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $product4 = Product::factory()->create([
            'name' => 'casaaa',
            'slug' => Str::slug('casaaa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 2]);
        $product4->images()->create([
            'url' => 'storage/enrf3.png'
        ]);


        $this->browse(function (Browser $browser) use ($product, $product1, $product2, $product3, $product4) {
            $browser->visit('/')
                ->pause(100)
                ->assertSee($product->name)
                ->assertSee($product1->name)
                ->assertSee($product2->name)
                ->assertSee($product3->name)
                ->assertSee($product4->name)
                ->screenshot('products');
        });
    }

    /** @test */
    public function notPublishedProducts_test()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);

        $subcategory = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Smartwatches',
                'slug' => Str::slug('Smartwatches'),
            ]);
        $category->brands()->create([
            'name' => 'loqsea'
        ]);
        $product = Product::factory()->create([
            'name' => 'casa',
            'slug' => Str::slug('casa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 1]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);

        $product6 = Product::factory()->create([
            'name' => 'mesa',
            'slug' => Str::slug('mesa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 2]);
        $product6->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $product1 = Product::factory()->create([
            'name' => 'casaaaa',
            'slug' => Str::slug('casaaaa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 1]);
        $product1->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $product2 = Product::factory()->create([
            'name' => 'coche',
            'slug' => Str::slug('coche'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 1]);
        $product2->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $product3 = Product::factory()->create([
            'name' => 'casaa',
            'slug' => Str::slug('casaa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 1]);
        $product3->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        $product4 = Product::factory()->create([
            'name' => 'casaaa',
            'slug' => Str::slug('casaaa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 1]);
        $product4->images()->create([
            'url' => 'storage/enrf3.png'
        ]);


        $this->browse(function (Browser $browser) use ($product6, $product, $product1, $product2, $product3,
            $product4) {
            $browser->visit('/')
                ->pause(100)
                ->assertDontSee($product->name)
                ->assertSee($product6->name)
                ->assertDontSee($product1->name)
                ->assertDontSee($product2->name)
                ->assertDontSee($product3->name)
                ->assertDontSee($product4->name)
                ->screenshot('notpublished');
        });
    }




    /** @test */
    public function productDetails_test()
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
            'url' => 'storage/aaa.png'
        ]);
        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->pause(100)
                ->clickLink($product->name)
                ->pause(100)
                ->assertSee($product->name)
                ->assertSee(ucfirst($product->brand->name))
                ->assertSee($product->quantity)
                ->assertSee($product->description)
                ->assertSee($product->price)
                ->assertPresent('img')
                ->assertButtonDisabled('-')
                ->assertButtonEnabled('+')
                ->assertButtonEnabled('AGREGAR AL CARRITO DE COMPRAS')
                ->screenshot('ProductsDetails');
        });

    }

    /** @test */
    public function buttonsLimits_test()
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
            'name' => 'marca2'
        ]);
        $product = Product::factory()->create([
            'name' => 'casa',
            'slug' => Str::slug('casa'),
            'description' => 'la casa asdd',
            'price' => 39.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 2,
            'status' => 2]);
        $product->images()->create([
            'url' => 'storage/aaa.png'
        ]);
        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->pause(100)
                ->clickLink($product->name)
                ->pause(100)
                ->assertSee($product->name)
                ->assertButtonDisabled('-')
                ->assertButtonEnabled('+')
                ->press('+')
                ->assertButtonDisabled('+')
                ->assertButtonEnabled('-')
                ->screenshot('ButtonLimits');
        });
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

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/')
                ->pause(100)
                ->clickLink($product->name)
                ->pause(100)
                ->assertSee($product->name)
                ->select('size')
                ->pause(100)
                ->select('color')
                ->screenshot('SizeAndColor-test');
        });

    }

    /** @test */
    public function productexample_test()
    {
        $product = $this->createProduct();
        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id)
                ->assertSee($product->name)
                ->screenshot('exampleRefact');
        });

    }


}
