@extends('layouts.base')

@section('title', 'Shopping Cart')

@section('body')
<header class="py-5 bg-gradient" style="background: linear-gradient(135deg, #ffecb3 0%, #fff8e1 100%);">
    <div class="container text-center">
        <h1 class="fw-bold" style="color: #e65100;">Your Shopping Cart</h1>
        <p class="lead">Complete Your Purchase</p>
    </div>
</header>

@include('layouts.flash-messages')

<div class="container py-4">
    @if (Session::has('cart'))
        <div class="row g-4">
            <!-- Cart Items Section -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-shopping-cart me-2 text-warning"></i>Cart Items
                        </h5>

                        <!-- Cart Items List -->
                        @foreach ($products as $product)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Product Image & Details -->
                                    <div class="col-lg-6 d-flex align-items-center">
                                        @php
                                        $firstImage = $product['item']->images->first()?->image_path;
                                        @endphp

                                        <img src="{{ $firstImage ? Storage::url($firstImage) : asset('images/default.png') }}"
                                            alt="{{ $product['item']['item_name'] }}"
                                            class="rounded-lg me-3"
                                            style="width: 80px; height: 80px; object-fit: contain;">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $product['item']['item_name'] }}</h5>
                                            <span class="fs-5 fw-bold text-warning">₱{{ number_format($product['item']['sell_price'], 2) }}</span>
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="col-lg-6 d-flex justify-content-end align-items-center mt-3 mt-lg-0">
                                        <form action="{{ route('updateCart', $product['item']['item_id']) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            <div class="input-group me-2" style="max-width: 140px;">
                                                <!-- Decrease Button -->
                                                <button type="button" class="btn btn-outline-warning" onclick="decreaseQuantity(this)">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <!-- Quantity Input -->
                                                <input type="number" name="quantity"
                                                    class="form-control text-center item-qty border-warning"
                                                    value="{{ $product['qty'] }}"
                                                    min="1"
                                                    readonly
                                                    data-price="{{ $product['item']['sell_price'] }}">

                                                <!-- Increase Button -->
                                                <button type="button" class="btn btn-outline-warning" onclick="increaseQuantity(this)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <button type="submit" class="btn btn-warning text-white rounded-pill me-2">
                                                <i class="fas fa-sync-alt me-1"></i>
                                            </button>
                                            
                                            <!-- Remove Button -->
                                            <a href="{{ route('removeItem', $product['item']['item_id']) }}" class="btn btn-outline-danger rounded-pill">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <!-- Continue Shopping Button -->
                        <div class="mt-4">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary & Checkout Section -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-lg mb-4 sticky-lg-top" style="top: 20px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-receipt me-2 text-warning"></i>Order Summary
                        </h5>

                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf

                            <!-- Shipping Details -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Shipping Information</h6>
                                
                                <div class="card bg-light border-0 rounded-lg p-3 mb-3">
                                    <div class="d-flex mb-2">
                                        <div class="text-muted me-2" style="width: 80px;">Name:</div>
                                        <div class="fw-medium">{{ $customer->fname }} {{ $customer->lname }}</div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="text-muted me-2" style="width: 80px;">Address:</div>
                                        <div class="fw-medium">{{ $customer->addressline }}, {{ $customer->town }}</div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="text-muted me-2" style="width: 80px;">Phone:</div>
                                        <div class="fw-medium">{{ $customer->phone }}</div>
                                    </div>
                                </div>
                                
                                <!-- Hidden fields to carry data -->
                                <input type="hidden" name="fname" value="{{ old('fname', $customer->fname) }}">
                                <input type="hidden" name="lname" value="{{ old('lname', $customer->lname) }}">
                                <input type="hidden" name="addressline" value="{{ old('addressline', $customer->addressline) }}">
                                <input type="hidden" name="town" value="{{ old('town', $customer->town) }}">
                                <input type="hidden" name="phone" value="{{ old('phone', $customer->phone) }}">

                                <!-- Shipping Method Dropdown -->
                                <label for="shippingSelect" class="form-label fw-medium">Shipping Method</label>
                                <select class="form-select rounded-pill border-light bg-light mb-3" name="shipping_id" id="shippingSelect" onchange="updateTotalPrice()">
                                    <option value="">-- Select Shipping Method --</option>
                                    @foreach ($shippingOptions as $option)
                                    <option value="{{ $option->shipping_id }}" data-rate="{{ $option->rate }}" {{ old('shipping_id') == $option->shipping_id ? 'selected' : '' }}>
                                        {{ $option->region }} - ₱{{ number_format($option->rate, 2) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Order Total -->
                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span>₱<span id="subtotalPrice">{{ number_format($totalPrice, 2) }}</span></span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Shipping:</span>
                                    <span>₱<span id="shippingPrice">0.00</span></span>
                                </div>
                                <div class="d-flex justify-content-between fs-5 fw-bold">
                                    <span>Total:</span>
                                    <span class="text-warning">₱<span id="totalPrice">{{ number_format($totalPrice, 2) }}</span></span>
                                </div>
                                
                                <!-- Checkout Button -->
                                <button type="submit" class="btn btn-warning w-100 mt-3 rounded-pill text-white">
                                    <i class="fas fa-lock me-2"></i>Proceed to Checkout
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart State -->
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-warning mb-3"></i>
            <h4 class="fw-bold mb-2">Your cart is empty</h4>
            <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-warning rounded-pill text-white">
                <i class="fas fa-store me-2"></i>Start Shopping
            </a>
        </div>
    @endif
</div>

<style>
    /* Matching styles from the shop page */
    .btn-warning.text-white {
        color: #fff !important;
        background-color: #e65100;
        border-color: #e65100;
    }
    
    .btn-outline-warning {
        color: #e65100;
        border-color: #e65100;
    }
    
    .btn-outline-warning:hover {
        background-color: #e65100;
        color: white;
    }
    
    .text-warning {
        color: #e65100 !important;
    }
    
    /* Animation for card hover */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767px) {
        .sticky-lg-top {
            position: relative;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        updateTotalPrice();
    });

    function decreaseQuantity(button) {
        let input = button.nextElementSibling;
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            updateTotalPrice();
        }
    }

    function increaseQuantity(button) {
        let input = button.previousElementSibling;
        input.value = parseInt(input.value) + 1;
        updateTotalPrice();
    }

    function updateTotalPrice() {
        let totalItemPrice = 0;
        const qtyInputs = document.querySelectorAll('.item-qty');

        qtyInputs.forEach(input => {
            const qty = parseInt(input.value);
            const price = parseFloat(input.getAttribute('data-price'));
            totalItemPrice += qty * price;
        });

        const shippingSelect = document.getElementById('shippingSelect');
        const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
        const shippingRate = selectedOption && selectedOption.value ? parseFloat(selectedOption.getAttribute('data-rate')) : 0;

        const total = totalItemPrice + shippingRate;

        document.getElementById('subtotalPrice').textContent = totalItemPrice.toFixed(2);
        document.getElementById('shippingPrice').textContent = shippingRate.toFixed(2);
        document.getElementById('totalPrice').textContent = total.toFixed(2);
    }

    document.getElementById('shippingSelect')?.addEventListener('change', updateTotalPrice);
</script>
@endsection