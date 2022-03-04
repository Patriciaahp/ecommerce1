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

        ];
    }
    public function search($query, $search)
    {
        $query->where('name', 'LIKE', "%{$search}%");


    }

}
