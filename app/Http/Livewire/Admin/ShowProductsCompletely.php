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

    public $search;
    use WithPagination;
    public $columns = ['Nombre','Categoría','Estado', 'Precio', 'Descripción', 'Cantidad', 'Marca', 'Subcategoría',
'Fecha de creación', 'Tallas', 'Color', 'Stock', 'Stock de color', 'Stock de talla'];
    public $selectedColumns = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where('name', 'LIKE', "%{$this->search}%")->paginate(10);


        return view('livewire.admin.show-products-completely', compact('products'))->layout('layouts.admin');


    }


        protected $queryString = [
        'search' => ['except' => ''],

    ];

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
                    'from' => request('from'),
                    'to' => request('to'),
                    'order' => request('order'),
                    'direction' => request('direction')]

            ))
            ->orderByDesc('created_at')
            ->paginate();

        $products->appends($productFilter->valid());

        return  $products;
    }


    }