<x-frontend-layout>
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white mb-5">
            Checkout</h1>

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
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-none">
                    @php
                        $subTotal = 0;
                    @endphp

                    @foreach ($carts as $cart)
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
                                {{ $cart->quantity }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                TK {{ $total }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-white dark:bg-gray-700 dark:text-white">
                        <td scope="row" colspan="4" class="px-6 py-4 text-sm font-medium dark:text-white">
                            <p class="text-end">Sub Total = </p>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium dark:text-white">
                            TK {{ $subTotal }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white my-5">
            Shipping Information</h1>

        <form method="post" action="{{ route('checkout.store') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    :value="old('name')" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"
                    :value="old('email')" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="mobile" :value="__('Mobile')" />
                <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full"
                    :value="old('mobile')" />
                <x-input-error class="mt-2" :messages="$errors->get('mobile')" />
            </div>

            <div>
                <x-input-label for="address" :value="__('Address')" />
                <textarea id="address" name="address" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1 block w-full">{{ old('address') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>

            <div>
                <p class="text-blue-700 font-semibold text-sm">Currently, we accept cash on delivery!</p>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>Place Order</x-primary-button>
            </div>
        </form>
    </div>
</x-frontend-layout>
