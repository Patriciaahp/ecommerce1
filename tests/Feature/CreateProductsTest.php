<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\CreateProduct;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;



    /** @test  */

   public function can_create_product_test()

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

        Livewire::test(CreateProduct::class)

            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('brand_id', $brand->id)
            ->set('name', 'mesa')
            ->set('slug', 'mesa-amarilla')


            ->set('description', 'mesa de plástico')
            ->set('price', 12.99)
            ->set('quantity', 11)
        ->call('save')
        ;



        $this->assertEquals(1, Product::count());
            $this->assertDatabaseHas('products', ['name' => 'mesa']);

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

        Livewire::test(CreateProduct::class)

            ->set('category_id', $category->id)
            ->set('subcategory_id', '')
            ->set('brand_id', $brand->id)
            ->set('name', 'mesa')
            ->set('slug', 'mesa-amarilla')


            ->set('description', 'mesa de plástico')
            ->set('price', 12.99)
            ->set('quantity', 11)
            ->call('save')
            ->assertHasErrors(['subcategory_id' => ['required']])
        ;

        $this->assertEquals(0, Product::count());
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

        Livewire::test(CreateProduct::class)

            ->set('category_id', '')
            ->set('subcategory_id', $subcategory->id)
            ->set('brand_id', $brand->id)
            ->set('name', 'mesa')
            ->set('slug', 'mesa-amarilla')


            ->set('description', 'mesa de plástico')
            ->set('price', 12.99)
            ->set('quantity', 11)
            ->call('save')
            ->assertHasErrors(['category_id' => ['required']])
        ;

        $this->assertEquals(0, Product::count());
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

        Livewire::test(CreateProduct::class)

            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('brand_id', $brand->id)
            ->set('name', '')
            ->set('slug', 'mesa-amarilla')


            ->set('description', 'mesa de plástico')
            ->set('price', 12.99)
            ->set('quantity', 11)
            ->call('save')
            ->assertHasErrors(['name' => ['required']])
        ;

        $this->assertEquals(0, Product::count());
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

        Livewire::test(CreateProduct::class)

            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('brand_id', $brand->id)
            ->set('name', 'mesa')
            ->set('slug', '')


            ->set('description', 'mesa de plástico')
            ->set('price', 12.99)
            ->set('quantity', 11)
            ->call('save')
            ->assertHasErrors(['slug' ])
        ;

        $this->assertEquals(0, Product::count());

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

        Livewire::test(CreateProduct::class)

            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('brand_id', $brand->id)
            ->set('name', 'mesa')
            ->set('slug', 'casa')


            ->set('description', 'mesa de plástico')
            ->set('price', 12.99)
            ->set('quantity', 11)
            ->call('save')
            ->assertHasErrors(['slug' ])
        ;

        $this->assertEquals(1, Product::count());

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

        Livewire::test(CreateProduct::class)

            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('brand_id', $brand->id)
            ->set('name', 'mesa')
            ->set('slug', 'mesa-amarilla')


            ->set('description', '')
            ->set('price', 12.99)
            ->set('quantity', 11)
            ->call('save')
            ->assertHasErrors(['description' ])
        ;

        $this->assertEquals(0, Product::count());

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

        Livewire::test(CreateProduct::class)

            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('brand_id', '')
            ->set('name', 'mesa')
            ->set('slug', 'mesa-amarilla')


            ->set('description', 'dsefefaf')
            ->set('price', 12.99)
            ->set('quantity', 11)
            ->call('save')
            ->assertHasErrors(['brand_id' ])
        ;

        $this->assertEquals(0, Product::count());

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

        Livewire::test(CreateProduct::class)

            ->set('category_id', $category->id)
            ->set('subcategory_id', $subcategory->id)
            ->set('brand_id', '')
            ->set('name', 'mesa')
            ->set('slug', 'mesa-amarilla')


            ->set('description', '')
            ->set('price', '')
            ->set('quantity', 11)
            ->call('save')
            ->assertHasErrors(['price' ])
        ;

        $this->assertEquals(0, Product::count());

    }


}
