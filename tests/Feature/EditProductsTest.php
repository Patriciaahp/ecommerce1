<?php

namespace Tests\Feature;


use App\Http\Livewire\Admin\EditProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class EditProductsTest extends TestCase
{

    use RefreshDatabase;
    use DatabaseMigrations;



    /** @test  */

    public function can_edit_product_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', $product->subcategory_id)
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', 'mesa')
            ->set('product.slug', 'mesa-amarilla')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', 12.99)
            ->set('product.quantity', 11)
            ->call('save')
        ;



        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'mesa',

        ]);

    }

    /** @test  */

    public function required_category_id_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', '')
            ->set('product.subcategory_id', $product->subcategory_id)
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', 'mesa')
            ->set('product.slug', 'mesa-amarilla')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', 12.99)
            ->set('product.quantity', 11)
            ->call('save')
            ->assertHasErrors('category_id')
        ;

        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa']);
         $this->assertDatabaseHas('subcategories', ['category_id' => 1]);
        $this->assertDatabaseHas('categories', ['id' => 1]);


    }

    /** @test  */

    public function required_subcategory_id_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', '')
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', 'mesa')
            ->set('product.slug', 'mesa-amarilla')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', 12.99)
            ->set('product.quantity', 11)
            ->call('save')
            ->assertHasErrors('product.subcategory_id')
        ;

        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa']);
        $this->assertDatabaseHas('subcategories', ['id' => 1]);



    }


    /** @test  */

    public function required_name_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', '')
            ->set('product.slug', 'mesa-amarilla')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', 12.99)
            ->set('product.quantity', 11)
            ->call('save')
            ->assertHasErrors('product.name')
        ;

        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa']);
        $this->assertDatabaseHas('subcategories', ['id' => 1]);

    }


    /** @test  */

    public function required_slug_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', 'mesa')
            ->set('product.slug', '')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', 12.99)
            ->set('product.quantity', 11)
            ->call('save')
            ->assertHasErrors('product.slug')
        ;

        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa']);
        $this->assertDatabaseHas('subcategories', ['id' => 1]);

    }



    /** @test  */

    public function unique_slug_test()

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
            'url' => 'storage/aaa.png'
        ]);

        $product2 = Product::factory()->create([
            'name' => 'coche',
            'slug' => Str::slug('coche'),
            'description' => 'asfdghg',
            'price' => 29.99,
            'subcategory_id' => 1,
            'brand_id' => 1,
            'quantity' => 12,
            'status' => 2]);
        $product2->images()->create([
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', 'mesa')
            ->set('product.slug', 'coche')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', 12.99)
            ->set('product.quantity', 11)
            ->call('save')
            ->assertHasErrors('product.slug')
        ;

        $this->assertEquals(2, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa',
        'slug' => 'casa']);


    }

    /** @test  */

    public function required_description_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', 'mesa')
            ->set('product.slug', 'mesa-amarilla')
            ->set('product.description', '')
            ->set('product.price', 12.99)
            ->set('product.quantity', 11)
            ->call('save')
            ->assertHasErrors('product.description')
        ;

        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa',
            'description' => 'la casa asdd'
            ]);


    }

    /** @test  */

    public function required_brand_id_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', '')
            ->set('product.name', 'mesa')
            ->set('product.slug', 'mesa-amarilla')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', 12.99)
            ->set('product.quantity', 11)
            ->call('save')
            ->assertHasErrors('product.brand_id')
        ;

        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa',
            'brand_id' => 1
        ]);


    }

    /** @test  */

    public function required_price_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', 'mesa')
            ->set('product.slug', 'mesa-amarilla')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', '')
            ->set('product.quantity', 11)
            ->call('save')
            ->assertHasErrors('product.price')
        ;

        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa',
            'price' => 39.99
        ]);


    }

    /** @test  */

    public function numeric_quantity_test()

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
            'url' => 'storage/aaa.png'
        ]);

        Livewire::test(EditProduct::class, ['product' => $product])

            ->set('category_id', $category->id)
            ->set('product.subcategory_id', $subcategory->id)
            ->set('product.brand_id', $product->brand_id)
            ->set('product.name', 'mesa')
            ->set('product.slug', 'mesa-amarilla')
            ->set('product.description', 'mesa de plástico')
            ->set('product.price', 19.99)
            ->set('product.quantity', 'hola')
            ->call('save')
            ->assertHasErrors('product.quantity')
        ;

        $this->assertEquals(1, Product::count());
        $this->assertDatabaseHas('products', ['name' => 'casa',
            'quantity' => 12
        ]);


    }


}
