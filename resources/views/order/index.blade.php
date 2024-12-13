<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('order List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form action="{{ route('orders.index') }}" method="get">
                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="name" :value="__('Customer Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="$name" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"
                                :value="$email" />
                        </div>

                        <div>
                            <x-input-label for="mobile" :value="__('Mobile')" />
                            <x-text-input id="mobile" name="mobile" type="text" class="mt-1 block w-full"
                                :value="$mobile" />
                        </div>

                        <div>
                            <x-primary-button class="sm:mt-6 py-3">Search</x-primary-button>
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
                                    Email</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Mobile</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Order Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Sub Total</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-none">
                            @php
                                $sl = $orders->firstItem();
                            @endphp
                            @forelse ($orders as $order)
                                <tr class="bg-white dark:bg-gray-700 dark:text-white">
                                    <th scope="row" class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $sl++ }}
                                    </th>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $order->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $order->email }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $order->mobile }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ $order->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        TK {{ $order->sub_total }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium dark:text-white">
                                        {{ str($order->status)->title() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white">
                                        <div class="space-x-2">
                                            <div class="flex gap-2">
                                                <a href="{{ route('orders.show', $order->id) }}"
                                                    class="underline text-green-500 hover:no-underline">View</a>
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
                                            order available!</span>
                                    </th>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
