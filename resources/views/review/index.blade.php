@extends('layouts.base')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-0">Your Reviews</h3>
    </div>

    @if($reviews->isEmpty())
        <div class="card border-0 shadow-sm rounded-3 p-4 text-center">
            <div class="py-4">
                <i class="bi bi-journal-text text-secondary" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-secondary">No Reviews Yet</h5>
                <p class="text-muted">You haven't submitted any reviews for your purchases yet.</p>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary mt-2">Browse Your Orders</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($reviews as $review)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden transition-all hover-shadow">
                        <div class="card-header bg-white border-0 pt-3 pb-0 px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge rounded-pill bg-light text-dark border">
                                    <i class="bi bi-tag me-1"></i>Order #{{ $review->orderinfo_id }}
                                </span>
                                <span class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="card-body px-3 pt-2">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3" style="width: 50px; height: 50px; overflow: hidden;">
                                    @if($review->item->thumbnail)
                                        <img src="{{ asset('storage/' . str_replace('public/', '', $review->item->thumbnail)) }}" 
                                             class="rounded-3 w-100 h-100 object-fit-cover" alt="{{ $review->item->item_name }}">
                                    @else
                                        <div class="bg-light rounded-3 w-100 h-100 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box text-secondary"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="card-title fw-bold mb-0">{{ $review->item->item_name }}</h5>
                                    <div class="d-flex align-items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} me-1"></i>
                                        @endfor
                                        <span class="ms-1 small text-muted">({{ $review->rating }}/5)</span>
                                    </div>
                                </div>
                            </div>

                            @if($review->review_text)
                                <div class="mb-3">
                                    <p class="card-text text-dark">{{ Str::limit($review->review_text, 120) }}</p>
                                </div>
                            @endif

                            {{-- Media Gallery --}}
                            @if($review->images->count())
                                <div class="position-relative mb-3">
                                    <div id="carouselReview{{ $review->review_id }}" class="carousel slide" data-bs-ride="false">
                                        <div class="carousel-inner rounded-3 overflow-hidden" style="height: 200px;">
                                            @foreach($review->images as $index => $media)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="height: 200px;">
                                                    @if(Str::endsWith($media->image_path, ['.mp4', '.webm', '.mov']))
                                                        <video controls class="w-100 h-100 object-fit-cover">
                                                            <source src="{{ asset('storage/' . str_replace('public/', '', $media->image_path)) }}">
                                                        </video>
                                                    @else
                                                        <img src="{{ asset('storage/' . str_replace('public/', '', $media->image_path)) }}"
                                                             class="w-100 h-100 object-fit-cover" alt="Review Media">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        @if($review->images->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselReview{{ $review->review_id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon bg-dark bg-opacity-50 rounded-circle p-2"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselReview{{ $review->review_id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon bg-dark bg-opacity-50 rounded-circle p-2"></span>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="position-absolute bottom-0 end-0 p-2">
                                        <span class="badge bg-dark bg-opacity-75 rounded-pill">
                                            <i class="bi bi-images me-1"></i>{{ $review->images->count() }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    @if($review->trashed())
                                        <i class="bi bi-archive-fill me-1"></i>Archived
                                    @endif
                                </span>
                                <div class="btn-group">
                                    @if($review->trashed())
                                        <form action="{{ route('reviews.restore', $review->review_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('reviews.edit', $review->review_id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>

                                        <form action="{{ route('reviews.destroy', $review->review_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush