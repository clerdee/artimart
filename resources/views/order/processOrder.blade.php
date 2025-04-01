@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white p-5 shadow rounded">
                <h2 class="mb-4 fw-bold text-primary">Order #{{ $customer->orderinfo_id }}</h2>

                <!-- Shipping Information -->
                <div class="mb-4">
                    <h4 class="text-dark mb-3">Shipping Information</h4>
                    <ul class="list-unstyled ps-3">
                        <li><strong>Name:</strong> {{ $customer->lname }} {{ $customer->fname }}</li>
                        <li><strong>Phone:</strong> {{ $customer->phone }}</li>
                        <li><strong>Address:</strong> {{ $customer->addressline }}</li>
                        <li><strong>Shipping Region:</strong> {{ $shippingRegion }}</li>
                        <li><strong>Shipping Rate:</strong> ₱{{ number_format($shippingRate, 2) }}</li>
                        <li><strong>Total Amount:</strong> ₱{{ number_format($total + $shippingRate, 2) }}</li>
                    </ul>
                </div>

                <!-- Order Status -->
                <div class="mb-4">
                    <h4 class="text-dark mb-3">Order Status</h4>
                    <p><strong>Current Status:</strong> <span class="badge bg-secondary px-3 py-2">{{ ucfirst($customer->status) }}</span></p>
                </div>

                <!-- Order Items -->
                <div class="mb-4">
                    <h4 class="text-dark mb-3">Order Items</h4>
                    <div class="border-top pt-3">
                        @foreach($orders as $order)
                        <div class="d-flex mb-4 align-items-start border rounded p-3 shadow-sm">
                            <div class="d-flex flex-wrap me-3" style="gap: 8px;">
                                @if(isset($images[$order->item_id]))
                                    @foreach ($images[$order->item_id] as $img)
                                    <img src="{{ Storage::url($img->image_path) }}" alt="{{ $order->description }}"
                                        style="width: 70px; height: 70px; object-fit: cover;" class="rounded shadow-sm border">
                                    @endforeach
                                @else
                                    <img src="{{ asset('default-placeholder.png') }}"
                                        class="img-thumbnail" style="width: 70px; height: 70px;" alt="No image">
                                @endif
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="fw-bold mb-1">{{ $order->description }}</h6>
                                <p class="mb-0">Price: ₱{{ number_format($order->sell_price, 2) }}</p>
                                <p class="mb-0">Quantity: {{ $order->quantity }} Piece(s)</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Update Status -->
                <div class="mt-5">
                    <h4 class="text-dark mb-3">Update Status</h4>
                    <form action="{{ route('admin.orderUpdate', $customer->orderinfo_id) }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="status" class="col-form-label">Order Status:</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" id="status" name="status">
                                    @foreach($statusChoices as $choice)
                                    <option value="{{ strtolower($choice) }}" {{ strtolower($status) == strtolower($choice) ? 'selected' : '' }}>
                                        {{ $choice }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Update Order Status</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection