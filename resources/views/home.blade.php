<x-frontend-layout>
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white mb-5">
            Latest Products</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div
                    class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-5">
                        <a href="{{ route('productDetails', $product->id) }}">
                            <h5
                                class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white underline hover:no-underline">
                                {{ $product->name }}</h5>
                        </a>

                        <p>Category: {{ $product->category?->name ?? 'N/A' }}</p>

                        <div class="flex items-center justify-between mt-5">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">TK
                                {{ $product->price }}</span>
                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                                to cart</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-2">
            {{ $products->links() }}
        </div>
    </div>
</x-frontend-layout>
