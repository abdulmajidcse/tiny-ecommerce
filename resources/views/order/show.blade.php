<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <a href="{{ route('orders.index') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Order List
                    </a>

                    <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white my-5">
                        Shipping Information</h1>

                    <div
                        class="mt-5 w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-5">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                Name: {{ $order->name }}</h5>

                            <div class="flex flex-col gap-1 mt-2">
                                <p>Email: {{ $order->email }}</p>
                                <p>Mobile: {{ $order->mobile }}</p>
                                <p>Address: {{ $order->address }}</p>
                                <p class="font-bold">Sub Total: TK {{ $order->sub_total }}</p>
                            </div>

                            <form method="POST" action="{{ route('orders.update', $order->id) }}">
                                @csrf
                                @method('put')
                                <div class="flex items-center gap-3">
                                    <div>
                                        <x-input-label for="status" :value="__('Order Status')" />
                                        <select id="status" name="status"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1 block w-full">
                                            @foreach (['pending', 'approved', 'canceled', 'processing', 'order placed', 'on the way', 'delivered'] as $statusValue)
                                                <option value="{{ $statusValue }}"
                                                    {{ $statusValue == $order->status ? 'selected' : '' }}>
                                                    {{ str($statusValue)->title() }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                                    </div>
                                    <div>
                                        <x-primary-button type="submit" class="sm:mt-6 py-3">Update</x-primary-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white my-5">
                    Order Details</h1>

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
                            @foreach ($order->OrderDetails as $orderDetail)
                            
                                <tr class="bg-white dark:bg-gray-700 dark:text-white">
                                    <th scope="row" class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $orderDetail->product?->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        TK {{ $orderDetail->selling_price }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $orderDetail->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        TK {{ $orderDetail->selling_price * $orderDetail->quantity }}
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
                                    TK {{ $order->sub_total }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
