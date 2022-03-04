<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Sortable;
use App\ProductFilter;
use Illuminate\Http\Request;


class ShowProductsCompletely extends Component
{
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    public $per_page = 15;
    public $search;
    use WithPagination;
    public $columns = ['Nombre','Categoría','Estado', 'Precio', 'Descripción', 'Cantidad', 'Marca', 'Subcategoría',
'Fecha de creación', 'Tallas', 'Color', 'Stock'];
    public $selectedColumns = [];

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(ProductFilter $productFilter)
    {
        return view('livewire.admin.show-products-completely',
            ['products' => $this->getProducts($productFilter)])->layout
    ('layouts.admin');

    }

        public function mount()
    {
        $this->selectedColumns = $this->columns;

    }

    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

        protected function getProducts(ProductFilter $productFilter)
    {
        $products = Product::query()
            ->filterBy($productFilter, array_merge(
                ['search' => $this->search,
                    ]
            ))
            ->orderByDesc('created_at')
            ->paginate($this->per_page);

        $products->appends($productFilter->valid());

        return  $products;
    }


    }
