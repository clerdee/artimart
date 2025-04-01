@extends('layouts.base')

@section('title', 'My Orders')

@section('body')
<header class="py-5 bg-gradient" style="background: linear-gradient(135deg, #ffecb3 0%, #fff8e1 100%);">
    <div class="container text-center">
        <h1 class="fw-bold" style="color: #e65100;">My Orders</h1>
        <p class="lead">Track and manage your purchases</p>
    </div>
</header>

@include('layouts.flash-messages')

<div class="container py-4">
    <!-- Status filter tabs with custom styling -->
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-body p-0">
            <ul class="nav nav-pills nav-fill p-3">
                <li class="nav-item px-1">
                    <a class="nav-link rounded-pill {{ $activeTab == 'all' ? 'active bg-warning text-white' : 'text-dark' }}" 
                       href="{{ route('orders.my', ['status' => 'all']) }}">
                        <i class="fas fa-shopping-bag me-2"></i>All Orders
                        <span class="badge bg-light text-dark ms-1">{{ $statusCounts['all'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link rounded-pill {{ $activeTab == 'Pending' ? 'active bg-warning text-white' : 'text-dark' }}" 
                       href="{{ route('orders.my', ['status' => 'Pending']) }}">
                        <i class="fas fa-clock me-2"></i>Pending
                        <span class="badge bg-light text-dark ms-1">{{ $statusCounts['Pending'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link rounded-pill {{ $activeTab == 'Shipped' ? 'active bg-warning text-white' : 'text-dark' }}" 
                       href="{{ route('orders.my', ['status' => 'Shipped']) }}">
                        <i class="fas fa-truck me-2"></i>Shipped
                        <span class="badge bg-light text-dark ms-1">{{ $statusCounts['Shipped'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link rounded-pill {{ $activeTab == 'Delivered' ? 'active bg-warning text-white' : 'text-dark' }}" 
                       href="{{ route('orders.my', ['status' => 'Delivered']) }}">
                        <i class="fas fa-check-circle me-2"></i>Delivered
                        <span class="badge bg-light text-dark ms-1">{{ $statusCounts['Delivered'] ?? 0 }}</span>
                    </a>
                </li>
                <li class="nav-item px-1">
                    <a class="nav-link rounded-pill {{ $activeTab == 'Cancelled' ? 'active bg-warning text-white' : 'text-dark' }}" 
                       href="{{ route('orders.my', ['status' => 'Cancelled']) }}">
                        <i class="fas fa-times-circle me-2"></i>Cancelled
                        <span class="badge bg-light text-dark ms-1">{{ $statusCounts['Cancelled'] ?? 0 }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    @forelse($orders as $order)
    <div class="card border-0 shadow-sm rounded-lg mb-4 product-card">
        <div class="card-header border-0 d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center">
                <span class="fw-bold fs-5 me-3">Order #{{ $order->orderinfo_id }}</span>
                
                <!-- Status Badge -->
                <span class="badge rounded-pill px-3 py-2
                    @if($order->status == 'Pending') bg-warning text-dark
                    @elseif($order->status == 'Shipped') bg-info text-white
                    @elseif($order->status == 'Delivered') bg-success text-white
                    @elseif($order->status == 'Cancelled') bg-secondary text-white
                    @else bg-primary text-white @endif">
                    @if($order->status == 'Pending')
                        <i class="fas fa-clock me-1"></i>
                    @elseif($order->status == 'Shipped')
                        <i class="fas fa-truck me-1"></i>
                    @elseif($order->status == 'Delivered')
                        <i class="fas fa-check-circle me-1"></i>
                    @elseif($order->status == 'Cancelled')
                        <i class="fas fa-times-circle me-1"></i>
                    @endif
                    {{ $order->status }}
                </span>
            </div>

            <!-- Action Buttons -->
            <div>
                @if ($order->status === 'Pending')
                <form action="{{ route('orders.cancel', $order->orderinfo_id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline-danger rounded-pill" 
                            onclick="return confirm('Are you sure you want to cancel this order?')">
                        <i class="fas fa-ban me-2"></i>Cancel Order
                    </button>
                </form>
                @elseif ($order->status === 'Delivered')
                @php
                $hasReview = \App\Models\Review::where('orderinfo_id', $order->orderinfo_id)
                ->where('customer_id', auth()->user()->customer->customer_id)
                ->exists();
                @endphp

                @if ($hasReview)
                <a href="{{ route('reviews.index') }}" class="btn btn-outline-info rounded-pill">
                    <i class="fas fa-star me-2"></i>View Review
                </a>
                @else
                <a href="{{ route('orders.review', $order->orderinfo_id) }}" class="btn btn-warning rounded-pill text-white">
                    <i class="fas fa-edit me-2"></i>Write Review
                </a>
                @endif
                @endif
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex">
                        <i class="fas fa-calendar-alt text-warning me-2 mt-1"></i>
                        <div>
                            <span class="text-muted">Order Date</span>
                            <p class="fw-medium mb-0">{{ \Carbon\Carbon::parse($order->date_placed)->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex">
                        <i class="fas fa-shipping-fast text-warning me-2 mt-1"></i>
                        <div>
                            <span class="text-muted">Shipping Method</span>
                            <p class="fw-medium mb-0">{{ $order->shipping_method }}
                                @if($order->shipping_rate > 0)
                                (₱{{ number_format($order->shipping_rate, 2) }})
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex">
                        <i class="fas fa-receipt text-warning me-2 mt-1"></i>
                        <div>
                            <span class="text-muted">Subtotal</span>
                            <p class="fw-medium mb-0">₱{{ number_format($order->subtotal, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex">
                        <i class="fas fa-money-bill-wave text-warning me-2 mt-1"></i>
                        <div>
                            <span class="text-muted">Total</span>
                            <p class="fw-bold fs-5 mb-0 text-warning">₱{{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mb-4">
            
            <h6 class="fw-bold mb-3">
                <i class="fas fa-box-open me-2 text-warning"></i>Items Ordered
            </h6>
            
            <div class="row g-3">
                @foreach($order->items as $item)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex">
                                @if (!empty($item->image_path))
                                <img src="{{ asset(str_replace('public/', 'storage/', $item->image_path)) }}"
                                    alt="{{ $item->description }}"
                                    class="me-3 rounded"
                                    width="80" height="80"
                                    style="object-fit: contain;">
                                @else
                                <img src="https://via.placeholder.com/80x80?text=No+Image"
                                    class="me-3 rounded"
                                    alt="No image">
                                @endif

                                <div>
                                    <h6 class="fw-bold mb-1">{{ $item->item_name }}</h6>
                                    <div class="small text-muted mb-1">Qty: {{ $item->quantity }} × ₱{{ number_format($item->sell_price, 2) }}</div>
                                    <div class="fw-medium text-warning">₱{{ number_format($item->sell_price * $item->quantity, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-4x text-warning mb-3"></i>
        <h4 class="fw-bold mb-2">No {{ $activeTab != 'all' ? strtolower($activeTab) . ' ' : '' }}orders found</h4>
        <p class="text-muted mb-4">You haven't placed any {{ $activeTab != 'all' ? strtolower($activeTab) . ' ' : '' }}orders yet.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-warning rounded-pill text-white">
            <i class="fas fa-store me-2"></i>Start Shopping
        </a>
    </div>
    @endforelse
</div>

<style>
    /* Consistent styling with ArtiMart brand */
    .btn-warning.text-white {
        color: #fff !important;
        background-color: #e65100;
        border-color: #e65100;
    }
    
    .btn-outline-warning {
        color: #e65100;
        border-color: #e65100;
    }
    
    .btn-outline-warning:hover, .nav-pills .nav-link.active {
        background-color: #e65100 !important;
        border-color: #e65100;
        color: white !important;
    }
    
    .text-warning {
        color: #e65100 !important;
    }
    
    /* Custom navigation pills styling */
    .nav-pills .nav-link {
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    
    .nav-pills .nav-link:not(.active):hover {
        background-color: #fff3e0;
        border-color: #ffe0b2;
    }
    
    /* Card hover effect */
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Badge positioning */
    .top-2 {
        top: 0.5rem;
    }
    
    .end-2 {
        right: 0.5rem;
    }
</style>
@endsection