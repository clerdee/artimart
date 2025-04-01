@extends('layouts.base')

@section('body')
@include('layouts.flash-messages')

<div class="card shadow rounded p-4 mb-4" style="background: linear-gradient(to right, #f8f9fa, #e9ecef);">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold text-dark mb-2 mb-md-0">
            <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
        </h2>
        <div class="badge bg-primary py-2 px-3 rounded-pill">
            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 rounded-3 shadow-sm h-100" style="background: linear-gradient(to right, #ffffff, #f8f9fa);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalOrders }}</h2>
                        </div>
                        <div class="rounded-pill bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-shopping-cart text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-primary rounded-pill shadow-sm">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 rounded-3 shadow-sm h-100" style="background: linear-gradient(to right, #ffffff, #f8f9fa);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Users</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
                        </div>
                        <div class="rounded-pill bg-success bg-opacity-10 p-3">
                            <i class="fas fa-users text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-success rounded-pill shadow-sm">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Controls --}}
    <div class="bg-white p-3 rounded shadow-sm mb-4">
        <form method="GET" action="{{ route('dashboard.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="start_date" class="form-label small text-muted">Start Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="far fa-calendar-alt"></i></span>
                    <input type="date" name="start_date" class="form-control border-0 shadow-sm" value="{{ $startDate }}">
                </div>
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label small text-muted">End Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="far fa-calendar-alt"></i></span>
                    <input type="date" name="end_date" class="form-control border-0 shadow-sm" value="{{ $endDate }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary rounded-pill w-100 shadow-sm">
                    <i class="fas fa-filter me-2"></i>Apply
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary rounded-pill w-100 shadow-sm">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Charts Section --}}
    <div class="row g-4">
        {{-- Monthly Sales --}}
        <div class="col-lg-8">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-chart-line me-2 text-primary"></i>Monthly Sales</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill dropdown-toggle" type="button" id="monthlyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            This Year
                        </button>
                        <ul class="dropdown-menu shadow" aria-labelledby="monthlyDropdown">
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                            <li><a class="dropdown-item" href="#">All Time</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    {!! $monthChart->container() !!}
                </div>
            </div>
        </div>

        {{-- Customer Demographics --}}
        <div class="col-lg-4">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-users me-2 text-success"></i>Customer Demographics</h5>
                </div>
                <div class="card-body">
                    {!! $customerChart->container() !!}
                </div>
            </div>
        </div>

        {{-- Yearly Sales --}}
        <div class="col-lg-4">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-alt me-2 text-info"></i>Yearly Sales</h5>
                </div>
                <div class="card-body">
                    {!! $yearChart->container() !!}
                </div>
            </div>
        </div>

        {{-- Product Sales Contribution --}}
        <div class="col-lg-8">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-warning"></i>Product Sales Contribution</h5>
                </div>
                <div class="card-body">
                    {!! $pieChart->container() !!}
                </div>
            </div>
        </div>

        {{-- Sales by Date Range --}}
        <div class="col-lg-12">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-chart-bar me-2 text-danger"></i>Sales by Date Range</h5>
                </div>
                <div class="card-body">
                    <div>
                        {!! $rangeChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card bg-light p-3 border-0 mt-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle text-primary fs-4 me-3"></i>
            <div>
                <h5 class="mb-1">Dashboard Information</h5>
                <p class="text-muted mb-0">This dashboard displays real-time sales data and user statistics. Filter by date range to see specific periods.</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{!! $customerChart->script() !!}
{!! $yearChart->script() !!}
{!! $monthChart->script() !!}
{!! $rangeChart->script() !!}
{!! $pieChart->script() !!}
@endpush
@endsection