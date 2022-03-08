<?php

namespace Tests\Feature;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\Traits\CreateData;

class DatabaseTest extends TestCase
{
    use DatabaseMigrations;
    use CreateData;
    use RefreshDatabase;

    //test pedido se crea en la base de datos





    /** @test */
    public function shopping_cart_is_saved_loging_out_test ()
    {



        $product = $this->createCustomProduct('sad', '12.99', '1', '1', '2',
            'movil','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0');

        $product2 = $this->createCustomProduct('sdaaf', '12.99', '1', '2', '2',
            'movila','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0' );



        $user = $this->createUser();
        $credentials = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => bcrypt('1234'),
        ];
        $this->post('/login', $credentials);
        $this->actingAs($user)
            ->get('/products' . $product->id)
            ->assertsee($product->quantity);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'weight' => 550,
        ]);

        $this->get('/products' . $product2->id)
        ->assertsee($product2->quantity);
        Cart::add([
            'id' => $product2->id,
            'name' => $product2->name,
            'qty' => 2,
            'price' => $product2->price,
            'weight' => 550,
        ]);
$this->get('/shopping-cart')
    ->assertSee($product->name)
    ->assertSee($product2->name)
    ->assertSee($product->price)
    ->assertSee($product2->price)
    ->assertSee($product->quantity)
    ->assertSee($product2->quantity );

        Auth::logout();
        $this->assertDatabaseHas('shoppingcart', ['identifier' => $user->id]);

        $this->post('/login', $credentials);
        $this->actingAs($user)
       ->get('/shopping-cart')
            ->assertSee($product->name)
            ->assertSee($product2->name)
            ->assertSee($product->price)
            ->assertSee($product2->price)
            ->assertSee($product->quantity)
            ->assertSee($product2->quantity );

    }


}
