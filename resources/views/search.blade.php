@extends('layouts.base')

@section('body')
<div class="container py-5">
    <!-- Success Alert -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
        <div class="d-flex align-items-center gap-3">
            <h1 class="fs-2 fw-bold m-0">Search Results</h1>
            @if (!$searchResults->isEmpty())
            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">
                {{ $searchResults->count() }} item(s)
            </span>
            @endif
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-left me-2"></i>Back to Browse
            </a>
        </div>
    </div>

    <!-- Empty State -->
    @if ($searchResults->isEmpty())
    <div class="text-center py-5 my-5">
        <div class="mb-4">
            <div class="bg-light rounded-circle p-4 d-inline-block">
                <i class="fas fa-search fa-3x text-secondary"></i>
            </div>
        </div>
        <h3 class="fw-bold mb-3">No results found</h3>
        <p class="text-muted mb-4 mx-auto" style="max-width: 500px">
            We couldn't find any matches for your search. Try different keywords or browse our categories.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-home me-2"></i>Return Home
            </a>
            <button class="btn btn-outline-dark rounded-pill px-4">
                <i class="fas fa-filter me-2"></i>Browse Categories
            </button>
        </div>
    </div>
    
    <!-- Search Results -->
    @else
    @foreach ($searchResults->groupByType() as $type => $modelSearchResults)
    <div class="mb-5">
        <!-- Section Header -->
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                <i class="fas fa-{{ $type == 'items' ? 'box' : 'tag' }} text-primary"></i>
            </div>
            <h2 class="fs-4 fw-bold m-0">{{ ucfirst($type) }}</h2>
            <span class="ms-3 badge bg-light text-dark rounded-pill">{{ count($modelSearchResults) }}</span>
        </div>
        
        <!-- Items Grid -->
        <div class="row g-4">
            @foreach ($modelSearchResults as $searchResult)
            @php
            $item = $searchResult->searchable;
            $imagePath = optional($item->firstImage)->image_path;
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-shadow transition-all">
                    <!-- Product Image -->
                    <div class="position-relative">
                        <img src="{{ $imagePath ? Storage::url($imagePath) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                            class="card-img-top"
                            style="height: 240px; object-fit: cover;"
                            alt="{{ $item->item_name }}">
                        <button class="btn btn-sm btn-light rounded-circle position-absolute top-3 end-3 shadow-sm wishlist-btn" 
                                data-bs-toggle="tooltip" title="Add to Wishlist">
                            <i class="far fa-heart"></i>
                        </button>
                        @if ($item->discount_percent > 0)
                        <div class="position-absolute top-3 start-3">
                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                -{{ $item->discount_percent }}%
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-2 product-title">{{ $item->item_name }}</h5>
                        <p class="card-text text-muted small mb-3">{{ Str::limit($item->description, 80) }}</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="fs-5 fw-bold text-primary">₱{{ number_format($item->sell_price, 2) }}</span>
                                @if ($item->original_price > $item->sell_price)
                                <span class="text-decoration-line-through text-muted ms-2 small">
                                    ₱{{ number_format($item->original_price, 2) }}
                                </span>
                                @endif
                            </div>
                            <div class="d-flex align-items-center">
                                @if ($item->rating)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <span class="small fw-bold">{{ number_format($item->rating, 1) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card-footer bg-white p-4 border-top-0">
                        <div class="d-flex gap-2">
                            <a href="{{ route('addToCart', $item->item_id) }}" class="btn btn-primary rounded-pill flex-grow-1 py-2">
                                <i class="fas fa-cart-plus me-1"></i><span class="small">Add to Cart</span>
                            </a>
                            <a href="{{ route('item.show', $item->item_id) }}" class="btn btn-outline-secondary rounded-circle p-2" 
                               data-bs-toggle="tooltip" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    
    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        <nav aria-label="Search results pagination">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link rounded-start-pill" href="#" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link rounded-end-pill" href="#" aria-label="Next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Wishlist button toggle
        document.querySelectorAll('.wishlist-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.replace('far', 'fas');
                    icon.classList.add('text-danger');
                } else {
                    icon.classList.replace('fas', 'far');
                    icon.classList.remove('text-danger');
                }
            });
        });
    });
</script>
@endsection