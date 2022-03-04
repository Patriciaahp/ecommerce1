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
    <div class="grid grid-rows-2 space-y-3 " >
    <select class="w-20 h-8 ml-4 " wire:model="per_page">
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="50">50</option>
    </select>

        <div   x-data="{ open: false }">
            <button class="bg-blue-400 ml-2 p-2 mb-2"  x-on:click="open = ! open"> Columnas</button>

            <div class=" ml-2 grid grid-cols-4 " x-show="open">
                @foreach($columns as $column)
                    <input  type="checkbox" wire:model="selectedColumns" value="{{$column}}">
                    <label class="col-2" >{{$column}}</label>
                @endforeach
            </div>
    </div>
    </div>
    <div class="p-4">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                        Nombre

                    </th>
                    @endif
                    @if(in_array('Categoría', $selectedColumns))
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                        Categoría

                    </th>
                        @endif
                        @if(in_array('Estado', $selectedColumns))
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                        Estado

                    </th>
                        @endif
                        @if(in_array('Precio', $selectedColumns))
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                        Precio

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
                    <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500
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
                                        <p>{{ __(ucfirst($size->name)) }}</p>
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
    </div>
</div>
</div>
</div>
</div>
