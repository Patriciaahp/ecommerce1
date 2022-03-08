<?php

namespace App\Filters;
use App\Filters\QueryFilter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductFilter extends QueryFilter
{

    public function rules(): array
    {
        return [
            'search' => 'filled',
            'category' => 'exists:categories,id',
            'subcategory' => 'exists:subcategories,id',
            'brand' => 'exists:brands,id',
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'dateFrom' => 'filled|date_format:d/m/Y',
            'dateTo' => 'filled|date_format:d/m/Y',

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
    public function brand($query, $brand)
    {
        $query->where('brand_id', $brand);
    }

    public function priceFrom($query, $price)
    {
        $query->where('price', '>=', $price);
    }
    public function priceTo($query, $price)
    {
        $query->where('price', '<=', $price);
    }
    public function dateFrom($query, $dateFrom)
    {
        $dateFrom = Carbon::createFromFormat('d/m/Y', $dateFrom);

        $query->whereDate('created_at', '>=', $dateFrom);
    }

    public function dateTo($query, $dateTo)
    {
        $dateTo = Carbon::createFromFormat('d/m/Y', $dateTo);

        $query->whereDate('created_at', '<=', $dateTo);
    }

}
