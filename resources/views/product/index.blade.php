<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <a href="{{ route('products.create') }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    New Product
                </a>

                <form action="{{ route('products.index') }}" method="get">
                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1 block w-full">
                                @foreach ($categories as $category)
                                    <option value="">Related Category</option>
                                    <option value="{{ $category->id }}"
                                        {{ $category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="$name" />
                        </div>

                        <div>
                            <x-input-label class="opacity-0" :value="__('Search')" />
                            <x-primary-button class="mt-1 py-3">Search</x-primary-button>
                        </div>
                    </div>
                </form>

                <div class="shadow overflow-x-auto border-b border-gray-200 dark:border-gray-700 sm:rounded-lg mt-5">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-none">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    SL</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    category</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Price</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Stock Quantity</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-none">
                            @php
                                $sl = $products->firstItem();
                            @endphp
                            @forelse ($products as $product)
                                <tr class="bg-white dark:bg-gray-700 dark:text-white">
                                    <th scope="row" class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $sl++ }}
                                    </th>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $product->category?->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        TK {{ $product->price }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        TK {{ $product->stock_quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white">
                                        <div class="space-x-2">
                                            <div class="flex gap-2" x-data="{ deleteIs: false }">
                                                <a href="{{ route('products.show', $product->id) }}"
                                                    class="underline text-green-500 hover:no-underline">View</a>

                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="underline text-blue-500 hover:no-underline">Edit</a>

                                                <button type="button" class="underline text-red-500 hover:no-underline"
                                                    x-on:click="deleteIs=true" x-show="!deleteIs">Delete</button>

                                                <div class="flex gap-2">
                                                    <form method="POST"
                                                        action="{{ route('products.destroy', $product->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <x-danger-button type="button" x-show="deleteIs"
                                                            onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                            Yes
                                                        </x-danger-button>
                                                    </form>
                                                    <x-secondary-button x-show="deleteIs" x-on:click="deleteIs=false">
                                                        No
                                                    </x-secondary-button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white dark:bg-gray-700 dark:text-white">
                                    <th scope="row"
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white"
                                        colspan="100">
                                        <span
                                            class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">No
                                            product available!</span>
                                    </th>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
