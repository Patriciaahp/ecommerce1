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
    <x-table-responsive>
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categoría
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precio
                            </th>
                            <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Descripción
                            </th>

                            <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Cantidad
                            </th>
                            <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Marca
                            </th>
                            <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Subcategoría
                            </th>
                            <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Fecha de creación
                            </th>
                            <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Tallas
                            </th>
                            <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Stock Tallas
                            </th>
                            <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Color
                            </th>
                            <th scope="col" class=" whitespace-nowrap px-6 py-3 text-left text-xs font-medium text-gray-500
                            uppercase tracking-wider">
                                Stock Color
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Editar</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                        <tr>
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $product->subcategory->category->name }}</div>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $product->status == 1 ? 'red' : 'green'}}-100 text-{{ $product->status == 1 ? 'red' : 'green' }}-800">
                                {{ $product->status == 1 ? 'Borrador' : 'Publicado' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->price }} &euro;
                            </td>
                            <td class=" px-6 py-4  text-sm text-gray-500">
                            <span class=" text-center  ">
                                <div class=" text-center" x-data="{ open: false }">
                     <button class="whitespace-pre-wrap text-left"  x-on:click="open = ! open"> {{ strlen
                     ($product->description) >= 30 ? (substr($product->description,0,20))  . '...':
                                ($product->description)}}</button >
                                    <div x-show="open" x-transition>
                            {{ (substr($product->description,20)) }}
                                            </div>
                                            </div>
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->getStockAttribute() === 0 ? 'Sin stock' : $product->getStockAttribute()}}
                            </td>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->brand->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->subcategory->name }}
                            </td>
                            <td class="px-6 py-4  text-sm text-gray-500">
                                {{ $product->created_at }}
                            </td>

                            <td class="px-6 py-4  text-sm text-gray-500">
                                {{ var_dump($product->color) }}
                            </td>
                            <td class="px-12 py-4  text-sm text-gray-500">
                                {{ var_dump($product->color) }}
                            </td>
                            <td class="px-6 py-4  text-sm text-gray-500">
                                {{ var_dump($product->color) }}
                            </td>
                            <td class="px-12 py-4  text-sm text-gray-500">
                                {{ var_dump($product->color) }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.products.edit', $product) }}" class=" text-indigo-600
                                hover:text-indigo-900">Editar</a>
                            </td>
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
    </div>
</div>
