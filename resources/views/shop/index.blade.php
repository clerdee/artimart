@extends('layouts.base')

@section('title', 'Plushie Shopping Cart')

@section('body')

<header class="py-5" style="background-color: #b3d9ff;">
    <div class="container text-center" style="color: #003d80;">
        <h1 class="fw-bolder">Welcome to SquishIT</h1>
        <p class="lead">Where Every Plushie is a Hug Waiting to Happen! 🐾✨</p>
    </div>
</header>

@include('layouts.flash-messages')

<style>
    .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: contain;
    }
</style>

<div class="container py-5">
    <!-- Filter Form -->
    <form method="GET" action="{{ route('shop.index') }}" class="mb-5">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="category_id" class="form-label text-primary">Filter by Category</label>
                <select name="category_id" id="category_id" class="form-select border-primary">
                    <option value="">-- All Categories --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                        {{ $category->description }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="min_price" class="form-label text-primary">Min Price (₱)</label>
                <input type="number" step="0.01" name="min_price" id="min_price" class="form-control border-primary" value="{{ request('min_price') }}">
            </div>

            <div class="col-md-2">
                <label for="max_price" class="form-label text-primary">Max Price (₱)</label>
                <input type="number" step="0.01" name="max_price" id="max_price" class="form-control border-primary" value="{{ request('max_price') }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('shop.index') }}" class="btn btn-outline-primary w-100">Clear</a>
            </div>
        </div>
    </form>

    <div class="row g-4">
        @foreach ($items as $item)
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm border-primary">
                @if ($images->has($item->item_id) && $images[$item->item_id]->count())
                <img src="{{ Storage::url($images[$item->item_id][0]->image_path) }}"
                    class="card-img-top"
                    alt="{{ $item->item_name }}"
                    style="width: 100%; height: 250px; object-fit: contain;">
                @else
                <img src="https://via.placeholder.com/400x250?text=No+Image"
                    class="card-img-top"
                    alt="No image"
                    style="width: 100%; height: 250px; object-fit: contain;">
                @endif

                <div class="card-body text-center">
                    <h5 class="card-title text-primary">{{ $item->item_name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($item->description, 50) }}</p>
                    <p class="fw-bold text-primary">₱{{ $item->sell_price }}</p>
                </div>
                <div class="card-footer text-center bg-light">
                    <a href="{{ route('addToCart', $item->item_id) }}" class="btn btn-primary">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </a>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#itemModal{{ $item->item_id }}">
                        View Details
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal for Item Details -->
        <div class="modal fade" id="itemModal{{ $item->item_id }}" tabindex="-1" aria-labelledby="itemModalLabel{{ $item->item_id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light text-primary">
                        <h5 class="modal-title" id="itemModalLabel{{ $item->item_id }}">{{ $item->item_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($images->has($item->item_id))
                        <div id="carouselItem{{ $item->item_id }}" class="carousel slide mb-3" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($images[$item->item_id] as $index => $img)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ Storage::url($img->image_path) }}"
                                        class="d-block w-100 img-fluid"
                                        alt="{{ $item->item_name }}"
                                        style="width: 100%; height: 400px; object-fit: contain;">
                                </div>
                                @endforeach
                            </div>

                            @if(count($images[$item->item_id]) > 1)
                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselItem{{ $item->item_id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselItem{{ $item->item_id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            @endif
                        </div>
                        @else
                        <img src="https://via.placeholder.com/400x400?text=No+Image"
                            class="d-block w-100 img-fluid"
                            alt="No image"
                            style="width: 100%; height: 400px; object-fit: contain;">
                        @endif
                        <p>{{ $item->description }}</p>
                        <p class="fw-bold text-primary">₱{{ $item->sell_price }}</p>
                        <hr>
                        <h6 class="text-start text-primary">Customer Reviews:</h6>
                        @if($reviews->has($item->item_id) && $reviews[$item->item_id]->count())
                        <div class="text-start">
                            {{-- Display review section --}}
                            @foreach ($reviews[$item->item_id] ?? [] as $review)
                            <div class="border-bottom mb-3 pb-3">
                                <strong>{{ $review->customer_name }}</strong><br>
                                <small class="text-muted">Order ID: #{{ $review->orderinfo_id }}</small><br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('F j, Y') }}</small>

                                {{-- Rating Stars --}}
                                @if($review->rating)
                                <div class="text-warning mt-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                        @endfor
                                </div>
                                @endif
                                <p class="mb-2">{{ $review->review_text }}</p>

                                {{-- Display Review Images --}}
                                @if (isset($reviewMedia[$review->review_id]))
                                <div class="row g-2">
                                    @foreach ($reviewMedia[$review->review_id] as $media)
                                    <div class="col-4">
                                        <img src="{{ Storage::url(str_replace('public/', '', $media->image_path)) }}"
                                            class="img-fluid rounded shadow-sm"
                                            alt="Review Image">
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted">No reviews yet.</p>
                        @endif
                    </div>
                    <div class="modal-footer bg-light">
                        <a href="{{ route('addToCart', $item->item_id) }}" class="btn btn-primary">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- End of Modal -->
        @endforeach
    </div>
</div>

@endsection