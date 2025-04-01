@extends('layouts.base')

@section('body')
<div class="container py-5">
    <h1 class="text-center mb-4 text-primary fw-bold">Admin Dashboard</h1>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3 shadow-sm">
                <div class="card-header">Total Orders</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalOrders }}</h5>
                    <a href="{{ route('admin.orders') }}" class="btn btn-light">View Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3 shadow-sm">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalUsers }}</h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-light">View Users</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row mb-4">
        {{-- Customer Demographics --}}
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header">Customer Demographics</div>
                <div class="card-body">
                    {!! $customerChart->container() !!}
                </div>
            </div>
        </div>

        {{-- Yearly Sales --}}
        <div class="col-lg-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header">Yearly Sales</div>
                <div class="card-body">
                    {!! $yearChart->container() !!}
                </div>
            </div>
        </div>

        {{-- Monthly Sales --}}
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">Monthly Sales</div>
                <div class="card-body">
                    {!! $monthChart->container() !!}
                </div>
            </div>
        </div>

        {{-- Sales by Date Range --}}
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Sales by Date Range</span>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.index') }}" class="mb-3">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-5">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                            </div>
                            <div class="col-md-5">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Apply</button>
                            </div>
                        </div>
                    </form>

                    {{-- Smaller chart inside --}}
                    <div style="height: 150px;">
                        {!! $rangeChart->container() !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Sales Contribution --}}
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">Product Sales Contribution</div>
                <div class="card-body">
                    {!! $pieChart->container() !!}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Render Chart Scripts --}}
{!! $customerChart->script() !!}
{!! $yearChart->script() !!}
{!! $monthChart->script() !!}
{!! $rangeChart->script() !!}
{!! $pieChart->script() !!}
@endsection