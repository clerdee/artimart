@extends('layouts.base')

@section('body')
@include('layouts.flash-messages')

<div class="card shadow rounded p-4 mb-4" style="background: linear-gradient(to right, #f8f9fa, #e9ecef);">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold text-dark mb-2 mb-md-0">
            <i class="fas fa-star me-2"></i>Customer Feedback
        </h2>
        <div class="badge bg-primary py-2 px-3 rounded-pill">
            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
        </div>
    </div>
    
    <div class="bg-white p-3 rounded shadow-sm mb-3">
        <div class="table-responsive">
            {{ $dataTable->table(['class' => 'table table-hover border-0 w-100', 'id' => 'reviews-table'], true) }}
        </div>
    </div>
    
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card bg-light p-3 border-0 h-100">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-chart-bar text-primary fs-4 me-3"></i>
                    <h5 class="mb-0">Rating Distribution</h5>
                </div>
                <div class="mt-2">
                    <!-- 5 Stars -->
                    <div class="d-flex align-items-center mb-2">
                        <div class="text-warning me-2" style="width: 100px;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    
                    <!-- 4 Stars -->
                    <div class="d-flex align-items-center mb-2">
                        <div class="text-warning me-2" style="width: 100px;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                    
                    <!-- 3 Stars -->
                    <div class="d-flex align-items-center mb-2">
                        <div class="text-warning me-2" style="width: 100px;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                    
                    <!-- 2 Stars -->
                    <div class="d-flex align-items-center mb-2">
                        <div class="text-warning me-2" style="width: 100px;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                    
                    <!-- 1 Star -->
                    <div class="d-flex align-items-center">
                        <div class="text-warning me-2" style="width: 100px;">
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card bg-light p-3 border-0 h-100">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-comment-dots text-primary fs-4 me-3"></i>
                    <h5 class="mb-0">Recent Comments</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
@endpush
@endsection