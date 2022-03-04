<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithPagination;
use App\Sortable;
use App\ProductFilter;
use Illuminate\Http\Request;


class ShowProductsCompletely extends Component
{
    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => 'all'],
        'subcategory' => ['except' => 'all'],
    ];
    public $per_page = 15;
    public $search;
    public $category = 'all';
    public $categories;
    public $subcategory= 'all';
    public $subcategories;
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
        $this->categories = Category::all();
        $this->subcategories = Subcategory::all();

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
                    'category' => $this->category,
                    'subcategory' => $this->subcategory,
                    ]
            ))
            ->orderByDesc('created_at')
            ->paginate($this->per_page);

        $products->appends($productFilter->valid());

        return  $products;
    }


    }
