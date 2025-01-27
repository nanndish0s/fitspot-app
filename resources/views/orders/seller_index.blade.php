@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">My Sales Orders</h2>
            <a href="{{ route('seller.dashboard') }}" class="text-green-600 hover:text-green-800 transition">
                Back to Dashboard
            </a>
        </div>

        @if($sellerOrders->isEmpty())
            <div class="p-6 text-center text-gray-600">
                <p class="text-xl">You haven't received any orders yet.</p>
                <p class="mt-2 text-sm">As you add more products, your sales will appear here.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Order ID</th>
                            <th class="py-3 px-6 text-left">Date</th>
                            <th class="py-3 px-6 text-left">Total Items</th>
                            <th class="py-3 px-6 text-left">Total Revenue</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($sellerOrders as $order)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">#{{ $order->id }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $order->orderItems->count() }} Items
                                </td>
                                <td class="py-3 px-6 text-left">
                                    ${{ number_format($order->orderItems->sum(function($item) {
                                        return $item->quantity * $item->price;
                                    }), 2) }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <span class="
                                        px-3 py-1 rounded-full text-xs font-bold
                                        {{ $order->status === 'completed' ? 'bg-green-200 text-green-800' : 
                                           ($order->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 
                                           'bg-red-200 text-red-800') }}
                                    ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $sellerOrders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
