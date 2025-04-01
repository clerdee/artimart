@extends('layouts.base')

@section('title', 'Shopping Cart')

@section('body')

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4 text-center text-primary">Shopping Cart</h2>

            @if (Session::has('cart'))
            <div class="list-group">
                @foreach ($products as $product)
                <div class="list-group-item">
                    <div class="row align-items-center">

                        <!-- COLUMN 1: Product Image & Details -->
                        <div class="col-md-6 d-flex align-items-center">
                            @php
                            $firstImage = $product['item']->images->first()?->image_path;
                            @endphp

                            <img src="{{ $firstImage ? Storage::url($firstImage) : asset('images/default.png') }}"
                                alt="Product Image"
                                width="80"
                                height="80"
                                class="rounded me-3">
                            <div>
                                <h5 class="mb-1 text-primary">{{ $product['item']['item_name'] }}</h5>
                                <small class="text-muted">₱{{ $product['item']['sell_price'] }}</small>
                            </div>
                        </div>

                        <!-- COLUMN 2: Quantity + Remove Button -->
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <form action="{{ route('updateCart', $product['item']['item_id']) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <div class="input-group me-2" style="max-width: 140px;">
                                    <!-- Decrease Button -->
                                    <button type="button" class="btn btn-outline-primary" onclick="decreaseQuantity(this)">-</button>

                                    <!-- Quantity Input -->
                                    <input type="number" name="quantity"
                                        class="form-control text-center item-qty border-primary"
                                        value="{{ $product['qty'] }}"
                                        min="1"
                                        readonly
                                        data-price="{{ $product['item']['sell_price'] }}">


                                    <!-- Increase Button -->
                                    <button type="button" class="btn btn-outline-primary" onclick="increaseQuantity(this)">+</button>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>

                            <!-- Remove Button -->
                            <a href="{{ route('removeItem', $product['item']['item_id']) }}" class="btn btn-danger ms-2">Remove</a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            <div class="container py-5">
                <!-- Customer & Shipping Details -->
                <div class="mt-4">
                    <h4 class="text-primary">Shipping Details</h4>
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" style="color: #1565C0;">First Name</label>
                            <input type="text" class="form-control border-primary" name="fname" value="{{ old('fname', $customer->fname) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #1565C0;">Last Name</label>
                            <input type="text" class="form-control border-primary" name="lname" value="{{ old('lname', $customer->lname) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #1565C0;">Address</label>
                            <input type="text" class="form-control border-primary" name="addressline" value="{{ old('addressline', $customer->addressline) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #1565C0;">Town</label>
                            <input type="text" class="form-control border-primary" name="town" value="{{ old('town', $customer->town) }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #1565C0;">Phone</label>
                            <input type="text" class="form-control border-primary" name="phone" value="{{ old('phone', $customer->phone) }}" readonly>
                        </div>

                        <!-- Shipping Method Dropdown -->
                        <div class="mb-3">
                            <label class="form-label" style="color: #1565C0;">Shipping Method</label>
                            <select class="form-control border-primary" name="shipping_id" id="shippingSelect" onchange="updateTotalPrice()">
                                <option value="">Select Shipping Method</option>
                                @foreach ($shippingOptions as $option)
                                <option value="{{ $option->shipping_id }}" data-rate="{{ $option->rate }}" {{ old('shipping_id') == $option->shipping_id ? 'selected' : '' }}>
                                    {{ $option->region }} - ₱{{ $option->rate }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-end">
                            <h4 class="text-primary">Total: <strong>₱<span id="totalPrice">{{ $totalPrice + $rate }}</span></strong></h4>
                            <button type="submit" class="btn btn-success mt-2">Proceed to Checkout</button>
                        </div>
                    </form>
                </div>
            </div>

            @else
            <div class="alert text-center" style="background-color: #E3F2FD; color: #1565C0; border: 1px solid #BBDEFB;">
                <h4 style="color: #0D47A1;">No Items in Cart!</h4>
                <p style="color: #1565C0;">Start shopping to add products to your cart.</p>
                <a href="{{ route('getItems') }}" class="btn btn-primary" style="background-color: #1565C0; border-color: #1565C0; color: #ffffff;">
                    Shop Now
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

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

        document.getElementById('totalPrice').textContent = total.toFixed(2);
    }

    document.getElementById('shippingSelect')?.addEventListener('change', updateTotalPrice);
</script>

@endsection