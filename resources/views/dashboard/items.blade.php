@extends('layouts.base')

@section('body')
@include('layouts.flash-messages')

<div class="card shadow-sm rounded p-4" style="background-color: #E3F2FD;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0 text-primary" style="font-family: 'Nunito', sans-serif;">Items List</h2>
        <span class="text-muted" style="font-family: 'Nunito', sans-serif;">Logged in as: <strong class="text-primary">{{ Auth::user()->name }}</strong></span>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
    <form method="POST" enctype="multipart/form-data" action="{{ route('item.import') }}" class="d-flex align-items-stretch gap-2 w-100">
        @csrf
        <div class="flex-grow-1">
            <input type="file" id="uploadName" name="item_upload" class="form-control h-100 border-primary" required style="font-family: 'Nunito', sans-serif; height: 38px;">
        </div>
        <button type="submit" class="btn btn-info text-white flex-shrink-0" style="font-family: 'Nunito', sans-serif; font-weight: 600; height: 38px; line-height: 1;">
            Import Excel
        </button>
    </form>
</div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <h4 class="text-primary" style="font-family: 'Nunito', sans-serif;">Items</h4>
        <a href="{{ route('items.create') }}" class="btn btn-primary" style="font-family: 'Nunito', sans-serif; font-weight: 600;">Add Item</a>
    </div>

    <div class="table-responsive mt-4">
        {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100', 'id' => 'items-table'], true) }}
    </div>
</div>

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
@endpush
@endsection