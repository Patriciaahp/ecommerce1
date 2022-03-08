<?php

namespace Tests\Traits;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Support\Str;

trait CreateData
{
    public function createProductT()
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

        return $product;
    }

    public function createProductOtherT()
    {
        return Product::factory()->create();
    }

    public function createUser()
    {
        $user = User::factory()->create([
            'name' => 'Paco García',
            'email' => 'paco@test.com',
            'password' => bcrypt('1234'),
        ]);
        return $user;
    }


    public function createCustomProduct($slug, $price, $subid, $quantity, $status, $name, $bname, $cid, $cname, $cslug,
                                        $sname, $sslug, $color, $colname, $colquantity)
    {
        $category = Category::factory()->create([
            'name' => $cname,
            'slug' => $cslug,
            'icon' => '<i class="fas fa-mobile-alt"></i>']);

        $subcategory = Subcategory::create(
            ['category_id' => $cid,
                'color' => $color,
                'name' => $sname,
                'slug' => $sslug,

            ]);
        $category->brands()->create([
            'name' => $bname
        ]);
        $product = Product::factory()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => 'la casa asdd',
            'price' => $price,
            'subcategory_id' => $subid,
            'brand_id' => 1,
            'quantity' => $quantity,
            'status' => $status]);
        $product->images()->create([
            'url' => 'storage/enrf3.png'
        ]);
        Color::create(['name' => $colname,]);
        $product->colors()->attach([1 => ['quantity' => $colquantity]]);


        return $product;
    }




}
