@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h4>Add Review - Order #{{ $order->orderinfo_id }}</h4>

    @foreach($items as $item)
    <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 border rounded shadow-sm bg-light">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->item_id }}">
        <input type="hidden" name="orderinfo_id" value="{{ $order->orderinfo_id }}">
        
        <div class="mb-3">
            <label class="form-label fw-bold">{{ $item->item_name }}</label>
        </div>

        @if($item->images->count())
        <div class="mb-3 d-flex justify-content-center">
            <div id="carouselItem{{ $item->item_id }}" class="carousel slide" data-bs-ride="carousel" style="max-width: 300px; width: 100%;">
                <div class="carousel-inner rounded shadow-sm">
                    @foreach($item->images as $index => $img)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . str_replace('public/', '', $img)) }}" class="d-block w-100 img-thumbnail" style="height: 200px; object-fit: cover;" alt="Item Image">
                    </div>
                    @endforeach
                </div>

                @if($item->images->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselItem{{ $item->item_id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselItem{{ $item->item_id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
                @endif
            </div>
        </div>
        @endif
        <div class="mb-3">
            <label class="form-label d-block">Rating:</label>
            <div class="star-rating">
                @for($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="star{{ $item->item_id }}_{{ $i }}" value="{{ $i }}" required>
                <label for="star{{ $item->item_id }}_{{ $i }}">&#9733;</label>
                @endfor
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Review</label>
            <textarea name="review_text" class="form-control" rows="3" placeholder="Write your review here..."></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Add Images or Videos</label>
            <input type="file" name="media_files[]" class="form-control" multiple accept="image/*,video/*">
        </div>

        <button type="submit" class="btn btn-success">Submit Review</button>
    </form>
    @endforeach
</div>

<style>
    .star-rating {
        direction: rtl;
        font-size: 1.5rem;
        display: inline-flex;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        color: #ccc;
        cursor: pointer;
        padding: 0 3px;
    }

    .star-rating input:checked~label,
    .star-rating input:checked~label~label {
        color: gold;
    }

    .star-rating label:hover,
    .star-rating label:hover~label {
        color: gold;
    }
</style>
@endsection