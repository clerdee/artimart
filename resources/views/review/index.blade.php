@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h4 class="text-primary">Your Reviews</h4>

    @if($reviews->isEmpty())
        <div class="alert alert-info mt-3" style="background-color: #E3F2FD; color: #1565C0; border: 1px solid #BBDEFB;">
            You haven't submitted any reviews yet.
        </div>
    @else
        <div class="row">
            @foreach($reviews as $review)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm rounded h-100">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">Order #{{ $review->orderinfo_id }}</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-2 text-primary">{{ $review->item->item_name }}</h5>

                            {{-- Star Rating --}}
                            <p class="mb-2">
                                Rating:
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-{{ $i <= $review->rating ? 'warning' : 'secondary' }}">&#9733;</span>
                                @endfor
                            </p>

                            {{-- Review Text --}}
                            <p class="card-text text-muted">{{ $review->review_text ?? 'No review text.' }}</p>

                            {{-- Media Carousel --}}
                            @if($review->images->count())
                                <div id="carouselReview{{ $review->review_id }}" class="carousel slide mb-3" data-bs-ride="carousel" style="max-width: 100%;">
                                    <div class="carousel-inner rounded">
                                        @foreach($review->images as $index => $media)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                @if(Str::endsWith($media->image_path, ['.mp4', '.webm', '.mov']))
                                                    <video controls class="d-block w-100 rounded" style="height: 300px; object-fit: cover;">
                                                        <source src="{{ asset('storage/' . str_replace('public/', '', $media->image_path)) }}">
                                                    </video>
                                                @else
                                                    <img src="{{ asset('storage/' . str_replace('public/', '', $media->image_path)) }}"
                                                         class="d-block w-100 rounded" style="height: 300px; object-fit: cover;" alt="Review Media">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($review->images->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselReview{{ $review->review_id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselReview{{ $review->review_id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <div class="d-flex justify-content-end">
                                @if($review->trashed())
                                    <form action="{{ route('reviews.restore', $review->review_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                                    </form>
                                @else
                                    <a href="{{ route('reviews.edit', $review->review_id) }}" class="btn btn-sm btn-primary me-2">
                                        Edit
                                    </a>

                                    <form action="{{ route('reviews.destroy', $review->review_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection