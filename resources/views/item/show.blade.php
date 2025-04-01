@extends('layouts.base')

@section('body')
<div class="container py-5">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Item Images -->
        <div class="col-md-6 text-center">
            @if ($images->count())
            <div id="itemCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($images as $index => $img)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ Storage::url($img->image_path) }}" 
                             class="d-block w-100 img-fluid rounded shadow-sm" 
                             style="height: 400px; object-fit: contain;" 
                             alt="{{ $item->item_name }}">
                    </div>
                    @endforeach
                </div>
                @if($images->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#itemCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#itemCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                @endif
            </div>
            @else
            <img src="https://via.placeholder.com/400x400?text=No+Image" 
                 class="img-fluid rounded shadow-sm" 
                 style="height: 400px; width: 400px; object-fit: cover;" 
                 alt="No image">
            @endif
        </div>

        <!-- Item Details -->
        <div class="col-md-6">
            <h2 class="text-primary fw-bold">{{ $item->item_name }}</h2>
            <p class="text-muted"><strong>Category:</strong> {{ $item->category ?? 'Uncategorized' }}</p>
            <p class="text-justify" style="text-align: justify;">{{ $item->description }}</p>
            <h4 class="text-primary fw-bold">₱{{ number_format($item->sell_price, 2) }}</h4>

            <a href="{{ route('addToCart', $item->item_id) }}" class="btn btn-primary mt-3">
                <i class="fas fa-cart-plus"></i> Add to Cart
            </a>
        </div>
    </div>

    <hr class="my-5">

    <!-- Customer Reviews -->
    <h4>Customer Reviews</h4>
    @if($reviews->count())
    @foreach ($reviews as $review)
    <div class="border-bottom mb-4 pb-3">
        <strong>{{ $review->customer_name ?? 'Anonymous' }}</strong><br>
        <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('F j, Y') }}</small>

        {{-- Rating --}}
        <div class="text-warning mt-1">
            @for ($i = 1; $i <= 5; $i++)
                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
            @endfor
        </div>

        <p class="mt-2">{{ $review->review_text }}</p>

        @if($reviewMedia->has($review->review_id))
        <div class="d-flex flex-wrap gap-2 mt-2">
            @foreach ($reviewMedia[$review->review_id] as $media)
            <img src="{{ Storage::url($media->image_path) }}" 
                 class="rounded shadow-sm" 
                 style="width: 150px; height: 150px; object-fit: cover;" 
                 alt="Review Image">
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
    @else
    <p class="text-muted">No reviews yet.</p>
    @endif
</div>
@endsection