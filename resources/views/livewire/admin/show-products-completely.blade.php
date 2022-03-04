<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                Lista de productos
            </h2>

            <x-button-link class="ml-auto" href="{{route('admin.products.create')}}">
                Agregar producto
            </x-button-link>
        </div>
    </x-slot>
    <x-table-responsive >
        <div class="grid gap-2 grid-cols-2 grid-rows-3" >
        <div  class="col-start-2 -space-x-8 " ><b>Número de artículos por página:</b>
    <select class="w-20 h-8 ml-4 " wire:model="per_page">
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="50">50</option>
    </select>
        </div>
        <div   x-data="{ open: false }">
            <button class="bg-blue-400 ml-2 p-2 mb-2"  x-on:click="open = ! open"> Columnas</button>

            <div class=" grid gap-4 grid-cols-3 grid-rows-3" x-show="open">
                @foreach($columns as $column)
                    <input  type="checkbox" wire:model="selectedColumns" value="{{$column}}">
                    <label class="col-2" >{{$column}}</label>
                @endforeach
            </div>
    </div>

        </div>
        <div>
        <div   x-data="{ open: false }">
            <button class="bg-red-500 ml-2 p-2 mb-2"  x-on:click="open = ! open"> Filtros</button>

            <div class=" space-x-10  ml-2 grid grid-cols-3 grid-rows-5 w-96" x-show="open">


                    <select class="h-12 w-40"  wire:model="category">
                        <option value='all' selected disabled>Categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>


                    <select class="h-12 w-60 " wire:model="subcategory">
                        <option value='all' selected disabled>Subcategorías</option>
                        @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                        @endforeach
                    </select>


                    <select class="h-12 w-40" wire:model="brand">
                        <option value='all' selected disabled>Marcas</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>



                    <div class="px-6 py-4">Precio desde:
                        <x-jet-input class="w-20"
                                     wire:model="priceFrom"
                                     type="text"
                                     placeholder="Desde" />
                    </div>


                        <div class="px-6 py-4">Precio hasta:
                            <x-jet-input class="w-20"
                                         wire:model="priceTo"
                                         type="text"
                                         placeholder="Hasta" />
                        </div>




                    <div class="px-6 py-4">Fecha desde:
                        <input id="date"
                               wire:model="dateFrom"
                               type="text"
                               placeholder="Desde" />
                    </div>


                    <div class="px-6 py-4">Fecha hasta:
                        <input id="date"
                               wire:model="dateTo"
                               type="text"
                               placeholder="Hasta" />
                    </div>

        </div>

        <div class="px-6 py-4">
            <x-jet-input class="w-full"
                         wire:model="search"
                         type="text"
                         placeholder="Introduzca el nombre del producto a buscar" />
        </div>

        @if($products->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    @if(in_array('Nombre', $selectedColumns))
                    <th wire:click="sort('products.name')" scope="col" class="px-6 py-3 text-left text-xs font-medium
                    text-gray-500
                    uppercase
                    tracking-wider">

                        <button >Nombre</button>

                    </th>
                    @endif
                    @if(in_array('Categoría', $selectedColumns))
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                        Categoría

                    </th>
                        @endif
                        @if(in_array('Estado', $selectedColumns))
            <div class="p-4">         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                        Estado

                    </th>
                        @endif
                        @if(in_array('Precio', $selectedColumns))
                    <th wire:click="sort('price')" scope="col" class="px-6 py-3 text-left text-xs font-medium
                    text-gray-500 uppercase
                    tracking-wider">

                      <button>Precio</button>

                    </th>
                        @endif
                        @if(in_array('Descripción', $selectedColumns))
                    <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">

                        Descripción

                    </th>
                        @endif
                        @if(in_array('Cantidad', $selectedColumns))
                    <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">

                        Cantidad

                    </th>
                        @endif
                        @if(in_array('Marca', $selectedColumns))
                    <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">

                        Marca

                    </th>
                        @endif
                        @if(in_array('Subcategoría', $selectedColumns))
                    <th wire:click="sort('subcategories.name')" scope="col" class=" px-6 py-3 text-left text-xs
                    font-medium
                    text-gray-500
                            uppercase tracking-wider">

                        Subcategoría

                    </th>
                        @endif
                        @if(in_array('Fecha de creación', $selectedColumns))
                    <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">

                        Fecha de creación

                    </th>
                        @endif
                        @if(in_array('Tallas', $selectedColumns))
                    <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">

                        Tallas

                    </th>

                        @endif
                        @if(in_array('Color', $selectedColumns))
                    <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">

                        Color

                    </th>
                        @endif
                        @if(in_array('Stock', $selectedColumns))
                    <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                        Stock
                    </th>
                        @endif

                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr>
                        @if(in_array('Nombre', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 object-cover">
                                    <img class="h-10 w-10 rounded-full" src="{{ $product->images->count() ? Storage::url($product->images->first()->url) :'img/default.jpg'}}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">

                                        {{ $product->name }}

                                    </div>
                                </div>
                            </div>
                        </td>
                        @endif
                            @if(in_array('Categoría', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $product->subcategory->category->name }}</div>
                        </td>
                            @endif
                                @if(in_array('Estado', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $product->status == 1 ? 'red' : 'green'}}-100 text-{{ $product->status == 1 ? 'red' : 'green' }}-800">

                                    {{ $product->status == 1 ? 'Borrador' : 'Publicado' }}

                                </span>
                        </td>
                            @endif
                            @if(in_array('Precio', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->price }} &euro;
                        </td>
                            @endif
                            @if(in_array('Descripción', $selectedColumns))
                        <td class=" px-6 py-4  text-sm text-gray-500">
                            <span class=" text-center  ">
                                <div class=" text-center" x-data="{ open: false }">
                     <button class="whitespace-pre-wrap text-left"  @click="open = ! open">
                         {{ strlen($product->description) >= 30 ? (substr($product->description,0,20))  . '...':
                                ($product->description)}}</button >
                                    <div x-show="open" x-transition>
                            {{ (substr($product->description,20)) }}
                                            </div>
                                            </div>
                            </span>
                        </td>
                            @endif
                            @if(in_array('Cantidad', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                            {{ $product->getStockAttribute() === 0 ? 'Sin stock' : $product->getStockAttribute()}}

                        </td>

                            @endif
                            @if(in_array('Marca', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                            {{ $product->brand->name }}

                        </td>
                            @endif
                            @if(in_array('Subcategoría', $selectedColumns))
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                            {{ $product->subcategory->name }}

                        </td>
                            @endif
                            @if(in_array('Fecha de creación', $selectedColumns))
                        <td class="px-6 py-4  text-sm text-gray-500">

                            {{ $product->created_at }}

                        </td>
                            @endif
                            @if(in_array('Tallas', $selectedColumns))
                                <td class="px-6 py-4  text-sm text-gray-500">
                                    {{  $product->sizes->count() ? ' ' : 'Sin stock' }}
                                    @foreach($product->sizes as $size)
                                        <b>{{ __(ucfirst($size->name)) }}</b>
                                        @foreach($size->colors as $color)
                                            <p>{{ __(ucfirst($color->name)) . '->' . $color->pivot->quantity  }}</p>

                                        @endforeach
                                    @endforeach
                                </td>
                            @endif





                        @if(in_array('Color', $selectedColumns))
                        <td class="px-6 py-4  text-sm text-gray-500">

                            {{  $product->colors->count() ? ' ' : 'Sin stock' }}

                            @foreach($product->colors as $color)
                                <p>{{ __(ucfirst($color->name))  . '->' . $color->pivot->quantity }}</p>

                            @endforeach
                        </td>
                            @endif
                            @if(in_array('Stock', $selectedColumns))
                        <td class="px-12 py-4  text-sm text-gray-500">
                            {{ $product->stock }}
                        </td>
                            @endif

                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="px-6 py-4">
                No existen productos coincidentes
            </div>
        @endif
        @if($products->hasPages())
            <div class="px-6 py-4">
                {{ $products->links() }}
            </div>
        @endif

    </x-table-responsive>
</div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            flatpickr('#date', {
                dateFormat: 'd/m/Y',
                altInput: true,
                altFormat:'d/m/Y'
            });
        });
    </script>
@endpush
