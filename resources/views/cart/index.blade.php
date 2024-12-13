<x-frontend-layout>
    <div>
        <div class="sm:flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white mb-5">
                Cart Details</h1>

            <div class="flex gap-2" x-data="{ deleteIs: false }">
                <x-danger-button type="button" x-on:click="deleteIs=true" x-show="!deleteIs">Empty Cart</x-danger-button>

                <div class="flex gap-2">
                    <form method="POST" action="{{ route('carts.destroy') }}">
                        @csrf
                        @method('delete')
                        <x-danger-button type="submit" x-show="deleteIs">
                            Yes
                        </x-danger-button>
                    </form>
                    <x-secondary-button x-show="deleteIs" x-on:click="deleteIs=false">
                        No
                    </x-secondary-button>
                </div>
            </div>
        </div>

        <div class="shadow overflow-x-auto border-b border-gray-200 dark:border-gray-700 sm:rounded-lg mt-5">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-none">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                            SL</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                            Product Name</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                            Price</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                            Quantity</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                            Total</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-none">
                    @php
                        $subTotal = 0;
                    @endphp

                    @forelse ($carts as $cart)
                        @php
                            $total = $cart->product->price * $cart->quantity;
                            $subTotal += $total;
                        @endphp
                        <tr class="bg-white dark:bg-gray-700 dark:text-white">
                            <th scope="row" class="px-6 py-4 text-sm font-medium dark:text-white">
                                {{ $loop->index + 1 }}
                            </th>
                            <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                {{ $cart->product->name }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                TK {{ $cart->product->price }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                <form method="POST" action="{{ route('carts.storeOrUpdate', $cart->product_id) }}">
                                    @csrf
                                    <div class="flex gap-3">
                                        <x-text-input id="quantity" name="quantity" type="number"
                                            class="max-w-[100px]" :value="$cart->quantity" min="1" />
                                        <x-primary-button>Update</x-primary-button>
                                    </div>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                TK {{ $total }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white">
                                <div class="space-x-2">
                                    <div class="flex gap-2" x-data="{ deleteIs: false }">
                                        <button type="button" class="underline text-red-500 hover:no-underline"
                                            x-on:click="deleteIs=true" x-show="!deleteIs">Delete</button>

                                        <div class="flex gap-2">
                                            <form method="POST" action="{{ route('carts.destroy', $cart->id) }}">
                                                @csrf
                                                @method('delete')
                                                <x-danger-button type="submit" x-show="deleteIs">
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
                            <th scope="row" class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white"
                                colspan="100">
                                <span
                                    class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">No
                                    cart item available!</span>
                            </th>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div
            class="mt-5 w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="p-5">
                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    Sub Total</h5>

                <div class="flex items-center justify-between mt-5">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">TK
                        {{ $subTotal }}</span>

                    <a href="{{ route('checkout.index') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
