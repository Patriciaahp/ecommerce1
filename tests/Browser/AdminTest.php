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
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

        /** @test */
        public function search_admin_test()
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


            $product2 = Product::factory()->create([
                'name' => 'queso',
                'slug' => Str::slug('queso'),
                'description' => 'queso azul',
                'price' => 19.99,
                'subcategory_id' => 1,
                'brand_id' => 1,
                'quantity' => 2,
                'status' => 2]);
            $product2->images()->create([
                'url' => 'storage/aaa.png'
            ]);


            $product3 = Product::factory()->create([
                'name' => 'falda',
                'slug' => Str::slug('falda'),
                'description' => 'falda verde',
                'price' => 39.99,
                'subcategory_id' => 1,
                'brand_id' => 1,
                'quantity' => 2,
                'status' => 2]);
            $product3->images()->create([
                'url' => 'storage/aaa.png'
            ]);


            $product4 = Product::factory()->create([
                'name' => 'pasta',
                'slug' => Str::slug('pasta'),
                'description' => 'pasta negra',
                'price' => 39.99,
                'subcategory_id' => 1,
                'brand_id' => 1,
                'quantity' => 2,
                'status' => 2]);
            $product4->images()->create([
                'url' => 'storage/aaa.png'
            ]);

            $role = Role::create(['name' => 'admin']);
            $admin = User::factory()->create([
                'name' => 'Paco García',
                'email' => 'paco@test.com',
                'password' => bcrypt('1234'),
            ])->assignRole('admin');


            $this->browse(function (Browser $browser) use ($admin, $product, $product2, $product3, $product4) {

                $browser
                    ->loginAs($admin)
                    ->visit('/admin')
                    ->assertSee('Lista de productos')
                    ->type('.border-gray-300 ', 'as')
               ->pause(200)
                    ->assertSee($product->name)
                    ->assertDontSee($product2->name)
                    ->assertDontSee($product3->name)
                    ->assertSee($product4->name)
                ->screenshot('search-admin');
            });

    }
}
