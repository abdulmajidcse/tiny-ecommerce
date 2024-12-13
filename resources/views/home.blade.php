<x-frontend-layout>
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white mb-5">
            Latest Products</h1>

        <form action="{{ url('/') }}" method="get">
            <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div>
                    <x-input-label for="category_id" :value="__('Category')" />
                    <select id="category_id" name="category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1 block w-full">
                        @foreach ($categories as $category)
                            <option value="">Related Category</option>
                            <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="name" :value="__('Product Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="$name" />
                </div>

                <div>
                    <x-primary-button class="sm:mt-6 py-3">Search</x-primary-button>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($products as $product)
                <div
                    class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <a href="{{ route('productDetails', $product->id) }}">
                            <h5
                                class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white underline hover:no-underline">
                                {{ $product->name }}</h5>
                        </a>

                        <p class="mt-3">Category: {{ $product->category?->name ?? 'N/A' }}</p>

                        <div class="flex items-center justify-between mt-5">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">TK
                                {{ $product->price }}</span>

                            <form method="POST" action="{{ route('carts.storeOrUpdate', $product->id) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                                    to cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <p class="text-red-600 font-semibold">Product not available! Try to broden your search.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-2">
            {{ $products->links() }}
        </div>
    </div>
</x-frontend-layout>
