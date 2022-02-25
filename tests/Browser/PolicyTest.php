<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PolicyTest extends DuskTestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;

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
}
