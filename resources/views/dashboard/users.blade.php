@extends('layouts.base')

@section('body')
@include('layouts.flash-messages')

<div class="card shadow-sm rounded p-4" style="background-color: #E3F2FD;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0 text-primary" style="font-family: 'Nunito', sans-serif;">Users List</h2>
        <span class="text-muted" style="font-family: 'Nunito', sans-serif;">Logged in as: <strong class="text-primary">{{ Auth::user()->name }}</strong></span>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <h4 class="text-primary" style="font-family: 'Nunito', sans-serif;">Users</h4>
    </div>

    <div class="table-responsive mt-4">
        {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100', 'id' => 'users-table'], true) }}
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
@endpush
@endsection