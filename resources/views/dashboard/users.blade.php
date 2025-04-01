@extends('layouts.base')

@section('body')
@include('layouts.flash-messages')

<div class="card shadow rounded p-4 mb-4" style="background: linear-gradient(to right, #f8f9fa, #e9ecef);">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold text-dark mb-2 mb-md-0">
            <i class="fas fa-users me-2"></i>User Management
        </h2>
        <div class="badge bg-primary py-2 px-3 rounded-pill">
            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
        </div>
    </div>

    <div class="bg-white p-3 rounded shadow-sm mb-3">
        <div class="table-responsive">
            {{ $dataTable->table(['class' => 'table table-hover border-0 w-100', 'id' => 'users-table'], true) }}
        </div>
    </div>
    
    <div class="card bg-light p-3 border-0">
        <div class="d-flex align-items-center">
            <i class="fas fa-shield-alt text-primary fs-4 me-3"></i>
            <div>
                <h5 class="mb-1">User Roles & Permissions</h5>
                <p class="text-muted mb-0">Manage access levels and permissions for different user roles through the table actions.</p>
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