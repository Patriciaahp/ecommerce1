<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    /** @test  */
    public function policy_test(){

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
        $user = User::factory()->create([
            'name' => 'Paco García',
            'email' => 'paco@test.com',
            'password' => bcrypt('1234'),
        ]);

        $user2 = User::factory()->create([
                'name' => 'Pepe García',
            'email' => 'pepe@test.com',
            'password' => bcrypt('1234'),
        ]);

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 550,

        ]);

        $order = new Order();
        $order->user_id = $user->id;
        $order->contact = 'Paco García';
        $order->phone = 123444;
        $order->envio_type = 2;
        $order->shipping_cost = 0;
        $order->total =  2;
        $order->status = 2;

        $order->content = Cart::content();



        $order->save();

        foreach (Cart::content() as $item) {
            discount($item);
        }
        $this->assertDatabaseHas('products', [
            'quantity' => $product->quantity -1
        ]);

        $this->actingAs($user)
            ->get('/orders/' . $order->id)
            ->assertSee('Resumen')
            ->assertsee($product->name)
            ->assertsee($product->price);


        Auth::logout();

        $this->actingAs($user2)
            ->get('/orders/'  . $order->id)
            ->assertStatus(302)

        ;

    }

}
