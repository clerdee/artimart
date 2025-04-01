@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h3>My Orders</h3>

    <!-- Status filter tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'all' ? 'active' : '' }}" href="{{ route('orders.my', ['status' => 'all']) }}">
                All Orders
                <span class="badge bg-secondary ms-1">{{ $statusCounts['all'] ?? 0 }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'Pending' ? 'active' : '' }}" href="{{ route('orders.my', ['status' => 'Pending']) }}">
                Pending
                <span class="badge bg-warning text-dark ms-1">{{ $statusCounts['Pending'] ?? 0 }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'Shipped' ? 'active' : '' }}" href="{{ route('orders.my', ['status' => 'Shipped']) }}">
                Shipped
                <span class="badge bg-info ms-1">{{ $statusCounts['Shipped'] ?? 0 }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'Delivered' ? 'active' : '' }}" href="{{ route('orders.my', ['status' => 'Delivered']) }}">
                Delivered
                <span class="badge bg-success ms-1">{{ $statusCounts['Delivered'] ?? 0 }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'Cancelled' ? 'active' : '' }}" href="{{ route('orders.my', ['status' => 'Cancelled']) }}">
                Cancelled
                <span class="badge bg-danger ms-1">{{ $statusCounts['Cancelled'] ?? 0 }}</span>
            </a>
        </li>
    </ul>

    @forelse($orders as $order)
    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center
                @if($order->status == 'Pending') bg-warning text-dark 
                @elseif($order->status == 'Shipped') bg-info text-white
                @elseif($order->status == 'Delivered') bg-success text-white
                @elseif($order->status == 'Cancelled') bg-secondary text-white
                @else bg-primary text-white @endif">

            <span class="fw-bold">Order #{{ $order->orderinfo_id }}</span>

            {{-- Action Buttons based on Order Status --}}
            <div>
                <span class="badge bg-light text-dark me-2">{{ $order->status }}</span>

                @if ($order->status === 'Pending')
                <form action="{{ route('orders.cancel', $order->orderinfo_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
                </form>
                @elseif ($order->status === 'Delivered')
                @php
                $hasReview = \App\Models\Review::where('orderinfo_id', $order->orderinfo_id)
                ->where('customer_id', auth()->user()->customer->customer_id)
                ->exists();
                @endphp

                @if ($hasReview)
                <a href="{{ route('reviews.index') }}" class="btn btn-info btn-sm">View Review</a>
                @else
                <a href="{{ route('orders.review', $order->orderinfo_id) }}" class="btn btn-primary btn-sm">Write Review</a>
                @endif
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Date Placed:</strong> {{ \Carbon\Carbon::parse($order->date_placed)->format('F d, Y') }}</p>
                    <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}
                        @if($order->shipping_rate > 0)
                        (₱{{ number_format($order->shipping_rate, 2) }})
                        @endif
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p><strong>Subtotal:</strong> ₱{{ number_format($order->subtotal, 2) }}</p>
                    <p><strong>Total:</strong> ₱{{ number_format($order->total, 2) }}</p>
                </div>
            </div>

            <hr>
            <h6 class="fw-bold">Items Ordered:</h6>
            <div class="row">
                @foreach($order->items as $item)
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        @if (!empty($item->image_path))
                        <img src="{{ asset(str_replace('public/', 'storage/', $item->image_path)) }}"
                            alt="{{ $item->description }}"
                            class="me-3 rounded"
                            width="80" height="80"
                            style="object-fit: cover;">
                        @else
                        <img src="https://via.placeholder.com/80x80?text=No+Image"
                            class="me-3 rounded"
                            alt="No image">
                        @endif

                        <div>
                            <div><strong>{{ $item->item_name }}</strong></div>
                            <div>Quantity: {{ $item->quantity }}</div>
                            <div>Price: ₱{{ number_format($item->sell_price, 2) }}</div>
                            <div>Subtotal: ₱{{ number_format($item->sell_price * $item->quantity, 2) }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-info">
        <p class="mb-0">You have no {{ $activeTab != 'all' ? strtolower($activeTab) . ' ' : '' }}orders yet.</p>
    </div>
    @endforelse
</div>

<style>
    .nav-tabs .nav-link {
        color: #6c757d;
    }

    .nav-tabs .nav-link.active {
        font-weight: bold;
        color: #212529;
    }
</style>
@endsection