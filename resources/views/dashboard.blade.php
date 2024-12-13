<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    You have <span class="font-bold">{{ $totalPendingOrders }} new</span> and <span
                        class="font-bold">{{ $totalDeliveredOrders }} delivered</span> orders of
                    <span class="font-bold">{{ $totalOrders }} orders</span>.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
