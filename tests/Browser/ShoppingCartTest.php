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
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;


class ShoppingCartTest extends DuskTestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    /** @test */
    public function productsWithoutColorAndSize_test()
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


        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id)
                -> pause(2000)
            ->assertSee('AGREGAR AL CARRITO DE COMPRAS')
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->assertSeeIn('.bg-red-600', '1')
                ->screenshot('WithoutSizeAndColor');


        });
    }
    /** @test */
    public function productWithColorAndSize_test()
    {

        $category2 = Category::factory()->create(['name' => 'Moda', 'slug' => Str::slug('Moda'),
            'icon' => '<i class="fas fa-tshirt"></i>'
        ]);

        $subcategory2 = Subcategory::create([
            'category_id' => 1,
            'name' => 'Hombres',
            'slug' => Str::slug('Hombres'),
            'color' => true, 'size' => true
        ]);

        $brand2 = $category2->brands()->create([
            'name' => 'marca2'
        ]);

        $product2 = Product::factory()->create([
            'name' => 'falda',
            'slug' => Str::slug('falda'),
            'description' => 'Falda azul',
            'price' => 19.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 2,
            'status' => 2,
        ]);
        $product2->images()->create([
            'url' => 'storage/aaa.png'
        ]);
        Color::create(['name' => 'Blanco',]);
        Color::create(['name' => 'Negro',]);
        $product2->colors()->attach([1 => ['quantity' => 10],
            2 => ['quantity' => 6]]);

        $size = Size::create(['name' => 'M',
            'product_id' => $product2->id]);

        $size->colors()->attach([1 => ['quantity' => 10],
            2 => ['quantity' => 10]]);


        $this->browse(function (Browser $browser) use ($product2) {
            $browser->visit('/products/' . $product2->id)
                -> pause(2000)
                ->assertSee('AGREGAR AL CARRITO DE COMPRAS')
                ->select('size')
                ->pause(2000)
                ->select('color')
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->assertSeeIn('.bg-red-600', '1')
                ->screenshot('WithColorAndSize');
        });
    }
    /** @test */
    public function productWithColor_test()
    {

        $category3 = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $subcategory3 = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Celulares Y Smartphones',
                'slug' => Str::slug('Smartwatches'),
                'color' => true
            ]);

        $brand3 = $category3->brands()->create([
            'name' => 'marca3'
        ]);
        $product3 = Product::factory()->create([
            'name' => 'tablet',
            'slug' => Str::slug('tablet'),
            'description' => 'tablet 3200px',
            'price' => 139.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 2]);
        $product3->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        Color::create(['name' => 'Blanco',]);
        Color::create(['name' => 'Negro',]);
        $product3->colors()->attach([1 => ['quantity' => 10],
            2 => ['quantity' => 6]]);


        $this->browse(function (Browser $browser) use ($product3) {
            $browser->visit('/products/' . $product3->id)
                -> pause(2000)
                ->assertSee('AGREGAR AL CARRITO DE COMPRAS')
                ->select('color')
                -> pause(2000)
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->assertSeeIn('.bg-red-600', '1')
                ->screenshot('WithtColor');
        });
    }

    /** @test */
    public function ShowItemsInShoppingCart_test()
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
            'quantity' => 4,
            'status' => 2]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);


        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id)
                -> pause(2000)
                ->assertSee('AGREGAR AL CARRITO DE COMPRAS')
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->press('.bg-red-600')
                -> pause(2000)
                ->assertSee('Total:')
                ->screenshot('ShowItems');


        });
    }

    /** @test */
    public function ItemsIncrementInShoppingCart_test()
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
            'quantity' => 4,
            'status' => 2]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);


        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id)
                -> pause(2000)
                ->assertSee('AGREGAR AL CARRITO DE COMPRAS')
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->press('.bg-red-600')
                -> pause(2000)
                ->assertSee('Cant: 1')
                ->press('+')
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->press('.bg-red-600')
                -> pause(2000)
                ->assertSee('Cant: 3')
                ->screenshot('ItemIncrement');


        });
    }
    /** @test */
    public function CanNotAddItemsToShoppingCart_test()
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


        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id)
                -> pause(2000)
                ->press('+')
                ->assertSee('AGREGAR AL CARRITO DE COMPRAS')
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->press('.bg-red-600')
                -> pause(2000)
                ->assertSee('Cant: 1')
                ->assertDontSee('Cant: 2')
                ->screenshot('ItemDontIncrement');


        });
    }
    /** @test */
    public function CanNotAddItemsWithColorAndSize_test()
    {

        $category2 = Category::factory()->create(['name' => 'Moda', 'slug' => Str::slug('Moda'),
            'icon' => '<i class="fas fa-tshirt"></i>'
        ]);

        $subcategory2 = Subcategory::create([
            'category_id' => 1,
            'name' => 'Hombres',
            'slug' => Str::slug('Hombres'),
            'color' => true, 'size' => true
        ]);

        $brand2 = $category2->brands()->create([
            'name' => 'marca2'
        ]);

        $product2 = Product::factory()->create([
            'name' => 'falda',
            'slug' => Str::slug('falda'),
            'description' => 'Falda azul',
            'price' => 19.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 1,
            'status' => 2,
        ]);
        $product2->images()->create([
            'url' => 'storage/aaa.png'
        ]);
        Color::create(['name' => 'Blanco',]);

        $product2->colors()->attach([1 => ['quantity' => 1]]);

        $size = Size::create(['name' => 'M',
            'product_id' => $product2->id]);

        $size->colors()->attach([1 => ['quantity' => 1]]);


        $this->browse(function (Browser $browser) use ($product2) {
            $browser->visit('/products/' . $product2->id)
                -> pause(2000)
                ->assertSee('AGREGAR AL CARRITO DE COMPRAS')
                ->select('size')
                ->pause(2000)
                ->select('color')
                ->press('+')
                ->pause(2000)
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->press('.bg-red-600')
                -> pause(2000)
                ->assertSee('Cant: 1')
                ->assertDontSee('Cant: 2')
                ->screenshot('CanNotAddWithColorAndSize');
        });
    }
    /** @test */
    public function CanNotAddproductWithColor_test()
    {

        $category3 = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $subcategory3 = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Celulares Y Smartphones',
                'slug' => Str::slug('Smartwatches'),
                'color' => true
            ]);

        $brand3 = $category3->brands()->create([
            'name' => 'marca3'
        ]);
        $product3 = Product::factory()->create([
            'name' => 'tablet',
            'slug' => Str::slug('tablet'),
            'description' => 'tablet 3200px',
            'price' => 139.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 1,
            'status' => 2]);
        $product3->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        Color::create(['name' => 'Blanco',]);

        $product3->colors()->attach([1 => ['quantity' => 1]]);


        $this->browse(function (Browser $browser) use ($product3) {
            $browser->visit('/products/' . $product3->id)
                -> pause(2000)
                ->assertSee('AGREGAR AL CARRITO DE COMPRAS')
                ->select('color')
                ->press('+')
                ->pause(2000)
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                -> pause(2000)
                ->press('.bg-red-600')
                -> pause(2000)
                ->assertSee('Cant: 1')
                ->assertDontSee('Cant: 2')
                ->screenshot('CanNotAddWithtColor');
        });
    }




    /** @test */
    public function AssertSeeStock_test()
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


        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id)
                -> pause(2000)
                ->assertSee('Stock disponible: ' . $product->quantity)
                ->screenshot('AssertSeeStock');


        });
    }
    /** @test */
    public function AssertSeeStockColorAndSize_test()
    {

        $category2 = Category::factory()->create(['name' => 'Moda', 'slug' => Str::slug('Moda'),
            'icon' => '<i class="fas fa-tshirt"></i>'
        ]);

        $subcategory2 = Subcategory::create([
            'category_id' => 1,
            'name' => 'Hombres',
            'slug' => Str::slug('Hombres'),
            'color' => true, 'size' => true
        ]);

        $brand2 = $category2->brands()->create([
            'name' => 'marca2'
        ]);

        $product2 = Product::factory()->create([
            'name' => 'falda',
            'slug' => Str::slug('falda'),
            'description' => 'Falda azul',
            'price' => 19.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 1,
            'status' => 2,
        ]);
        $product2->images()->create([
            'url' => 'storage/aaa.png'
        ]);
        Color::create(['name' => 'Blanco',]);

        $product2->colors()->attach([1 => ['quantity' => 1]]);

        $size = Size::create(['name' => 'M',
            'product_id' => $product2->id]);

        $size->colors()->attach([1 => ['quantity' => 1]]);


        $this->browse(function (Browser $browser) use ($product2) {
            $browser->visit('/products/' . $product2->id)
                -> pause(2000)
                ->assertSee('Stock disponible: ' . $product2->quantity)
                ->screenshot('AssertSeeStockWithColorAndSize');
        });
    }
    /** @test */
    public function AssertSeeStockWithColor_test()
    {

        $category3 = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $subcategory3 = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Celulares Y Smartphones',
                'slug' => Str::slug('Smartwatches'),
                'color' => true
            ]);

        $brand3 = $category3->brands()->create([
            'name' => 'marca3'
        ]);
        $product3 = Product::factory()->create([
            'name' => 'tablet',
            'slug' => Str::slug('tablet'),
            'description' => 'tablet 3200px',
            'price' => 139.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 1,
            'status' => 2]);
        $product3->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        Color::create(['name' => 'Blanco',]);

        $product3->colors()->attach([1 => ['quantity' => 1]]);


        $this->browse(function (Browser $browser) use ($product3) {
            $browser->visit('/products/' . $product3->id)
                -> pause(2000)
                ->assertSee('Stock disponible: ' . $product3->quantity)
                ->screenshot('AssertSeeStockWithtColor');
        });
    }
}
