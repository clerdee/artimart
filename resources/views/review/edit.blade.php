@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h4>Edit Review - Review #{{ $review->review_id }}</h4>

    <form action="{{ route('reviews.update', $review->review_id) }}" method="POST" enctype="multipart/form-data" class="mb-5 p-4 border rounded shadow-sm bg-light">
        @csrf
        @method('PUT')

        <input type="hidden" name="item_id" value="{{ $review->item_id }}">

        <div class="mb-3">
            <label class="form-label fw-bold">{{ $review->item_name ?? 'Item' }}</label>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Rating:</label>
            <div class="star-rating">
                @for($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ $review->rating == $i ? 'checked' : '' }}>
                <label for="star{{ $i }}">&#9733;</label>
                @endfor
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Review</label>
            <textarea name="review_text" class="form-control" rows="3">{{ $review->review_text }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Add Images or Videos</label>
            <input type="file" name="media_files[]" class="form-control" multiple accept="image/*,video/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Review</button>
    </form>
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
