<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductFilter extends QueryFilter
{

    public function rules(): array
    {
        return [
            'search' => 'filled',
            'category' => 'exists:categories,id',
            'subcategory' => 'exists:subcategories,id'

        ];
    }
    public function search($query, $search)
    {
        $query->where('name', 'LIKE', "%{$search}%");


    }
    public function category($query, $category)
    {
         $query->where(function ($query) use($category) {

         $query->whereHas('subcategory', function ($q) use($category) {
            $q->where('subcategories.category_id', $category);
        });
        });

    }

    public function subcategory($query, $subcategory)
    {
                $query->where('subcategory_id', $subcategory);



    }


}
