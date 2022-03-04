<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Sortable;
use App\ProductFilter;
use Illuminate\Http\Request;


class ShowProductsCompletely extends Component
{
    public $per_page = 15;
    public $search;
    public $category = 'all';
    public $categories;
    public $subcategory= 'all';
    public $subcategories;
    public $brand = 'all';
    public $brands;
    public $priceFrom ;
    public $priceTo ;
    public $dateFrom;
    public $dateTo;
    public $sortColumn = 'name';
    public $sortDirection = 'asc';

    use WithPagination;
    public $columns = ['Nombre','Categoría','Estado', 'Precio', 'Descripción', 'Cantidad', 'Marca', 'Subcategoría',
'Fecha de creación', 'Tallas', 'Color', 'Stock'];
    public $selectedColumns = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => 'all'],
        'subcategory' => ['except' => 'all'],
        'brand' => ['except' => 'all' ],
        'priceFrom' => [ 'except' => '' ],
        'priceTo' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],

    ];
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingCategory()
    {
        $this->resetPage();
    }
    public function updatingSubcategory()
    {
        $this->resetPage();
    }
    public function updatingPriceFrom()
    {
        $this->resetPage();
    }
    public function updatingPriceTo()
    {
        $this->resetPage();
    }
    public function updatingDateFrom()
    {
        $this->resetPage();
    }
    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function sort($column)
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc' ;
    }

    public function updatedCategory($value)
    {
        $this->subcategories = Subcategory::where('category_id', $value)->get();
        $this->brands = Brand::whereHas('categories', function(Builder $query) use ($value) {
            $query->where('category_id', $value);
        })->get();
        $this->reset(['subcategory', 'brand']);
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
        $this->brands = Brand::all();


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
                    'brand' => $this->brand,
                    'priceFrom' => $this->priceFrom,
                    'priceTo' => $this->priceTo,
                    'dateFrom' => $this->dateFrom,
                    'dateTo' => $this->dateTo,
                    ]
            ))
            ->join('subcategories', 'subcategories.id', 'products.subcategory_id')
            ->select('products.*')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->per_page);

        $products->appends($productFilter->valid());

        return  $products;
    }


    }
