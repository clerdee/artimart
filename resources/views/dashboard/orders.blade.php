@extends('layouts.base')

@section('body')
@include('layouts.flash-messages')

<div class="card shadow rounded p-4 mb-4" style="background: linear-gradient(to right, #f8f9fa, #e9ecef);">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold text-dark mb-2 mb-md-0">
            <i class="fas fa-shopping-cart me-2"></i>Order Management
        </h2>
        <div class="badge bg-primary py-2 px-3 rounded-pill">
            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
        </div>
    </div>
    
    <!-- <div class="bg-white p-3 rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-download me-1"></i> Export
                </button>
            </div>
            
            <div class="input-group w-auto">
                <input type="text" class="form-control" placeholder="Search orders...">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div> -->
        
        <div class="table-responsive">
            {{ $dataTable->table(['class' => 'table table-hover border-0 w-100', 'id' => 'orders-table'], true) }}
        </div>
    </div>
    
    <!-- <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted small">
            <i class="fas fa-info-circle me-1"></i> Click on any order to view details
        </div>
        <a href="#" class="btn btn-sm btn-success">
            <i class="fas fa-chart-line me-1"></i> View Analytics
        </a>
    </div> -->
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
@endpush
@endsection