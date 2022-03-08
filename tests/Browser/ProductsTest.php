<?php

namespace Tests\Browser;

use Tests\Traits\CreateData;
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


class ProductsTest extends DuskTestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;


    /** @test */

public function see_products_test()
{
    $product = $this->createCustomProduct('sad', '12.99', '1', '1', '2',
        'movil','nokia', '1', 'moviles y tablets',
        'moviles-tablets', 'moviles', 'moviles', false, '', '');
    $product2 = $this->createCustomProduct('sdaaf', '12.99', '1', '1', '2',
        'movila','nokia', '1', 'moviles y tablets',
        'moviles-tablets', 'moviles', 'moviles', false, '', '' );
    $product3 = $this->createCustomProduct('sadsf', '12.99', '1', '1', '2',
        'movilb','nokia', '1', 'moviles y tablets',
        'moviles-tablets', 'moviles', 'moviles', false, '', '' );
    $product4 = $this->createCustomProduct('dfsf', '12.99', '1', '1', '2',
        'movilc','nokia', '1', 'moviles y tablets',
        'moviles-tablets', 'moviles', 'moviles', false, '', '');
    $product5 = $this->createCustomProduct('fgvsf', '12.99', '1', '1', '1',
        'movild','nokia', '1', 'moviles y tablets',
        'moviles-tablets', 'moviles', 'moviles', false, '', '');

    $this->browse(function (Browser $browser) use ($product, $product2, $product3, $product4, $product5) {
        $browser->visit('/')
            ->pause(100)
            ->assertSee($product->name)
            ->assertSee($product2->name)
            ->assertSee($product3->name)
            ->assertSee($product4->name)
            ->assertDontSee($product5->name)
            ->screenshot('products');
            });
}

/** @test */
    public function not_published_products_test()
    {
        $product = $this->createCustomProduct('sad', '12.99', '1', '1', '1',
            'movilll','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0' );
        $product2 = $this->createCustomProduct('sdaaf', '12.99', '1', '1', '1',
            'movila','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0' );
        $product3 = $this->createCustomProduct('sadsf', '12.99', '1', '1', '1',
            'movilb','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0');
        $product4 = $this->createCustomProduct('dfsf', '12.99', '1', '1', '1',
            'movilc','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0' );
        $product5 = $this->createCustomProduct('fgvsf', '12.99', '1', '1', '2',
            'movild','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0' );

        $this->browse(function (Browser $browser) use ($product, $product2, $product3, $product4, $product5) {
            $browser->visit('/')
                ->pause(200)
                ->assertDontSee($product->name)
                ->assertDontSee($product2->name)
                ->assertDontSee($product3->name)
                ->assertDontSee($product4->name)
                ->assertSee($product5->name)
                ->screenshot('not_published');
        });
    }


    /** @test */
    public function productDetails_test()
    {
        $product = $this->createCustomProduct('sad', '12.99', '1', '6', '2',
            'movilll','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0' );
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
        $product = $this->createCustomProduct('sad', '12.99', '1', '2', '2',
            'movilll','nokia', '1', 'moviles y tablets',
            'moviles-tablets', 'moviles', 'moviles', false, '', '0' );
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
        $product = $this->createProductT();
        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products/' . $product->id)
                ->assertSee($product->name)
                ->screenshot('exampleRefact');
        });

    }


}
