@extends('layouts.base')

@section('title', 'Plushie Shopping Cart')

@section('body')
<header class="py-5 bg-gradient" style="background: linear-gradient(135deg, #ffecb3 0%, #fff8e1 100%);">
    <div class="container text-center">
        <h1 class="fw-bold" style="color: #e65100;">Welcome to ArtiMart</h1>
        <p class="lead">Where Creativity Meets Quality</p>
    </div>
</header>

@include('layouts.flash-messages')

<div class="container py-4">
    <!-- Filter Section -->
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('shop.index') }}">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-filter me-2 text-warning"></i>Shop Filters
                </h5>
                
                <div class="row g-3 align-items-end">
                    <!-- Category Filter -->
                    <div class="col-lg-4 col-md-6">
                        <label for="category_id" class="form-label fw-medium">Category</label>
                        <select name="category_id" id="category_id" class="form-select rounded-pill border-light bg-light">
                            <option value="">-- All Categories --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" 
                                    {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Filters -->
                    <div class="col-lg-2 col-md-3 col-6">
                        <label for="min_price" class="form-label fw-medium">Min Price (₱)</label>
                        <input type="number" step="0.01" name="min_price" id="min_price" 
                            class="form-control rounded-pill border-light bg-light" 
                            value="{{ request('min_price') }}">
                    </div>

                    <div class="col-lg-2 col-md-3 col-6">
                        <label for="max_price" class="form-label fw-medium">Max Price (₱)</label>
                        <input type="number" step="0.01" name="max_price" id="max_price" 
                            class="form-control rounded-pill border-light bg-light" 
                            value="{{ request('max_price') }}">
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-lg-2 col-md-6 col-6">
                        <button type="submit" class="btn btn-warning rounded-pill w-100 text-white">
                            <i class="fas fa-search me-2"></i>Apply
                        </button>
                    </div>

                    <div class="col-lg-2 col-md-6 col-6">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary rounded-pill w-100">
                            <i class="fas fa-undo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        @foreach ($items as $item)
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm rounded-lg product-card">
                    <!-- Product Image Section -->
                    <div class="position-relative">
                        @if ($images->has($item->item_id) && $images[$item->item_id]->count())
                            <img src="{{ Storage::url($images[$item->item_id][0]->image_path) }}"
                                class="card-img-top"
                                alt="{{ $item->item_name }}"
                                style="height: 250px; object-fit: contain; padding: 1rem;">
                        @else
                            <img src="https://via.placeholder.com/400x250?text=No+Image"
                                class="card-img-top"
                                alt="No image"
                                style="height: 250px; object-fit: contain; padding: 1rem;">
                        @endif
                        
                        <button class="btn btn-sm btn-light rounded-circle position-absolute top-2 end-2 shadow-sm wishlist-btn">
                            <i class="far fa-heart text-danger"></i>
                        </button>
                    </div>

                    <!-- Product Info Section -->
                    <div class="card-body text-center p-3">
                        <h5 class="card-title fw-bold text-truncate">{{ $item->item_name }}</h5>
                        <p class="card-text small text-muted mb-3">
                            {{ Str::limit($item->description, 50) }}
                        </p>
                        
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="fs-5 fw-bold text-warning">₱{{ number_format($item->sell_price, 2) }}</span>
                            <div class="d-flex align-items-center">
                                <div class="me-1">
                                    <i class="fas fa-star text-warning"></i>
                                    <span class="small">
                                        @if($reviews->has($item->item_id) && $reviews[$item->item_id]->count())
                                            {{ number_format($reviews[$item->item_id]->avg('rating'), 1) }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons Section -->
                    <div class="card-footer bg-white p-3 border-top-0">
                        <div class="d-flex gap-2">
                            <a href="{{ route('addToCart', $item->item_id) }}" class="btn btn-warning rounded-pill flex-grow-1 text-white">
                                <i class="fas fa-cart-plus me-1"></i> Add
                            </a>
                            <button class="btn btn-outline-dark rounded-circle" 
                                data-bs-toggle="modal" 
                                data-bs-target="#itemModal{{ $item->item_id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Item Details -->
            <div class="modal fade" id="itemModal{{ $item->item_id }}" 
                tabindex="-1" 
                aria-labelledby="itemModalLabel{{ $item->item_id }}" 
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 rounded-lg overflow-hidden">
                        <!-- Modal Header -->
                        <div class="modal-header bg-orange-50 border-0">
                            <h5 class="modal-title fw-bold" id="itemModalLabel{{ $item->item_id }}">
                                {{ $item->item_name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <!-- Modal Body -->
                        <div class="modal-body p-0">
                            <div class="row g-0">
                                <!-- Product Images Carousel -->
                                <div class="col-md-6">
                                    @if ($images->has($item->item_id))
                                        <div id="carouselItem{{ $item->item_id }}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach ($images[$item->item_id] as $index => $img)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                        <img src="{{ Storage::url($img->image_path) }}"
                                                            class="d-block w-100 img-fluid"
                                                            alt="{{ $item->item_name }}"
                                                            style="height: 400px; object-fit: contain;">
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if(count($images[$item->item_id]) > 1)
                                                <button class="carousel-control-prev" type="button" 
                                                    data-bs-target="#carouselItem{{ $item->item_id }}" 
                                                    data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" 
                                                    data-bs-target="#carouselItem{{ $item->item_id }}" 
                                                    data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <img src="https://via.placeholder.com/400x400?text=No+Image"
                                            class="d-block w-100 img-fluid"
                                            alt="No image"
                                            style="height: 400px; object-fit: contain;">
                                    @endif
                                </div>
                                
                                <!-- Product Details -->
                                <div class="col-md-6 p-4">
                                    <h4 class="fw-bold mb-2">{{ $item->item_name }}</h4>
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            <span class="fs-4 fw-bold text-warning">
                                                ₱{{ number_format($item->sell_price, 2) }}
                                            </span>
                                        </div>
                                        
                                        <div>
                                            @if($reviews->has($item->item_id) && $reviews[$item->item_id]->count())
                                                <span class="badge bg-warning text-dark rounded-pill px-2">
                                                    <i class="fas fa-star me-1"></i>
                                                    {{ number_format($reviews[$item->item_id]->avg('rating'), 1) }}
                                                </span>
                                                <small class="text-muted ms-1">
                                                    ({{ $reviews[$item->item_id]->count() }} reviews)
                                                </small>
                                            @else
                                                <span class="badge bg-light text-dark rounded-pill px-2">
                                                    No ratings yet
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <p class="mb-4">{{ $item->description }}</p>
                                    
                                    <div class="d-grid gap-2 mb-3">
                                        <a href="{{ route('addToCart', $item->item_id) }}" 
                                            class="btn btn-warning btn-lg rounded-pill text-white">
                                            <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                        </a>
                                        <button class="btn btn-outline-danger rounded-pill">
                                            <i class="far fa-heart me-2"></i> Add to Wishlist
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Reviews Section -->
                            <div class="p-4 border-top">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-comment-dots text-warning me-2"></i>
                                    Customer Reviews
                                    @if($reviews->has($item->item_id) && $reviews[$item->item_id]->count())
                                        <span class="badge bg-warning text-dark rounded-pill ms-2">
                                            {{ $reviews[$item->item_id]->count() }}
                                        </span>
                                    @endif
                                </h5>
                                
                                @if($reviews->has($item->item_id) && $reviews[$item->item_id]->count())
                                    <div>
                                        @foreach ($reviews[$item->item_id] as $review)
                                            <div class="border-bottom mb-3 pb-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <strong>{{ $review->customer_name }}</strong>
                                                        <div class="text-warning">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($review->created_at)->format('F j, Y') }}
                                                    </small>
                                                </div>
                                                
                                                <p class="my-2">{{ $review->review_text }}</p>
                                                
                                                @if (isset($reviewMedia[$review->review_id]))
                                                    <div class="row g-2 mt-2">
                                                        @foreach ($reviewMedia[$review->review_id] as $media)
                                                            <div class="col-4 col-lg-3">
                                                                <img src="{{ Storage::url(str_replace('public/', '', $media->image_path)) }}"
                                                                    class="img-fluid rounded shadow-sm"
                                                                    alt="Review Image">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        Order ID: #{{ $review->orderinfo_id }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No reviews yet for this product.</p>
                                        <p class="small text-muted">Be the first to share your experience!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Modal -->
        @endforeach
    </div>
    
    <!-- Empty State (Show only if no products) -->
    @if($items->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-4x text-warning mb-3"></i>
            <h4 class="text-muted">No products found</h4>
            <p class="text-muted">Try adjusting your filter criteria or check back later.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-warning rounded-pill mt-3 text-white">
                <i class="fas fa-redo me-2"></i>Reset Filters
            </a>
        </div>
    @endif
</div>

<style>
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .wishlist-btn {
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }
    
    .wishlist-btn:hover {
        opacity: 1;
        background-color: white;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        background-color: rgba(0, 0, 0, 0.4); /* Increased contrast */
        width: 50px; /* Increased size */
        height: 50px; /* Increased size */
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        border: 2px solid white; /* Added border for visibility */
    }
    
    .carousel-control-prev {
        left: 15px; /* Adjusted for better visibility */
    }
    
    .carousel-control-next {
        right: 15px; /* Adjusted for better visibility */
    }

    /* Text-white fix for better contrast on warning buttons */
    .btn-warning.text-white {
        color: #fff !important;
    }

    /* Modal header warm color */
    .bg-orange-50 {
        background-color: #fff3e0;
    }
</style>
@endsection