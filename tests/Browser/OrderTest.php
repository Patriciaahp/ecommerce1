<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OrderTest extends DuskTestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;


    /** @test */
    public function stock_changes_adding_to_cart_test()
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
            'quantity' => 3,
            'status' => 2]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);

        $user =  User::factory()->create([
            'name' => 'Paco García',
            'email' => 'paco@test.com',
            'password' => bcrypt('1234'),
        ]);

        $this->browse(function (Browser $browser) use ($product, $user) {
            $browser
                ->loginAs($user)
                ->visit('/products/ ' . $product->id )
                ->assertSee( 'Stock disponible: 3')
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                ->pause(2000)
                ->assertSee('Stock disponible: 2' )
                ->screenshot('stock-changes') ;
        });
    }
    /** @test */
    public function stock_changes_adding_to_cart_color_size_product_test()
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

        $product->colors()->attach([1 => ['quantity' => 2]]);

        $size =   Size::create(['name' => 'M',
            'product_id' => $product->id]);

        $size->colors()->attach([1=>['quantity' => 2]]);

        $user =  User::factory()->create([
            'name' => 'Paco García',
            'email' => 'paco@test.com',
            'password' => bcrypt('1234'),
        ]);

        $this->browse(function (Browser $browser) use ($product, $user) {
            $browser
                ->loginAs($user)
                ->visit('/products/ ' . $product->id )
                ->assertSee( 'Stock disponible: 2')
                ->select('size')
                ->pause(200)
                ->select('color')->pause(200)
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                ->pause(2000)
                ->assertSee('Stock disponible: 1' )
                ->screenshot('stock-changes-color-size') ;
        });
    }

    /** @test */
    public function stock_changes_adding_to_cart_color_product_test()
    {
        $category = Category::factory()->create(['name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'icon' => '<i class="fas fa-mobile-alt"></i>']);
        $subcategory = Subcategory::create(
            ['category_id' => 1,
                'name' => 'Celulares Y Smartphones',
                'slug' => Str::slug('Smartwatches'),
                'color' => true
            ]);

        $brand = $category->brands()->create([
            'name' => 'marca3'
        ]);
        $product = Product::factory()->create([
            'name' => 'tablet',
            'slug' => Str::slug('tablet'),
            'description' => 'tablet 3200px',
            'price' => 139.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 2,
            'status' => 2]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        Color::create(['name' => 'Blanco',]);

        $product->colors()->attach([1 => ['quantity' => 2]]);


        $user =  User::factory()->create([
            'name' => 'Paco García',
            'email' => 'paco@test.com',
            'password' => bcrypt('1234'),
        ]);

        $this->browse(function (Browser $browser) use ($product, $user) {
            $browser
                ->loginAs($user)
                ->visit('/products/ ' . $product->id )
                ->assertSee( 'Stock disponible: 2')
                ->select('color')->pause(200)
                ->press('AGREGAR AL CARRITO DE COMPRAS')
                ->pause(2000)
                ->assertSee('Stock disponible: 1' )
                ->screenshot('stock-changes-color') ;
        });
    }


}
