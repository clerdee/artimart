@php
use Collective\Html\FormFacade as Form;
use App\Models\Category;
@endphp

@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Item</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'items.store', 'files' => true]) !!}

                    <!-- Item Name -->
                    <div class="mb-3">
                        {!! Form::label('item_name', 'Item Name', ['class' => 'form-label fw-bold']) !!}
                        {!! Form::text('item_name', null, [
                            'class' => 'form-control',
                            'id' => 'item_name',
                            'required' => true,
                            'placeholder' => 'Enter Item Name',
                        ]) !!}
                        @error('item_name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        {!! Form::label('description', 'Description', ['class' => 'form-label fw-bold']) !!}
                        {!! Form::text('description', null, [
                            'class' => 'form-control',
                            'id' => 'description',
                            'required' => true,
                            'placeholder' => 'Enter Item Description',
                        ]) !!}
                        @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Cost Price -->
                    <div class="mb-3">
                        {!! Form::label('cost_price', 'Cost Price', ['class' => 'form-label fw-bold']) !!}
                        {!! Form::number('cost_price', 0.00, [
                            'min' => 0.00,
                            'step' => 0.01,
                            'class' => 'form-control',
                            'id' => 'cost_price',
                            'required' => true,
                            'placeholder' => 'Enter Cost Price',
                        ]) !!}
                        @error('cost_price')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sell Price -->
                    <div class="mb-3">
                        {!! Form::label('sell_price', 'Sell Price', ['class' => 'form-label fw-bold']) !!}
                        {!! Form::number('sell_price', 0.00, [
                            'min' => 0.00,
                            'step' => 0.01,
                            'class' => 'form-control',
                            'id' => 'sell_price',
                            'required' => true,
                            'placeholder' => 'Enter Sell Price',
                        ]) !!}
                        @error('sell_price')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        {!! Form::label('category_id', 'Category', ['class' => 'form-label fw-bold']) !!}
                        {!! Form::select('category_id', ['' => 'Select Category'] + Category::pluck('description', 'category_id')->toArray(), null, [
                            'class' => 'form-control',
                            'required' => true,
                        ]) !!}
                        @error('category_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        {!! Form::label('qty', 'Quantity', ['class' => 'form-label fw-bold']) !!}
                        {!! Form::number('qty', null, [
                            'class' => 'form-control',
                            'id' => 'qty',
                            'placeholder' => 'Enter Quantity',
                        ]) !!}
                        @error('qty')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Images -->
                    <div class="mb-3">
                        {!! Form::label('images[]', 'Upload Images', ['class' => 'form-label fw-bold']) !!}
                        {!! Form::file('images[]', [
                            'class' => 'form-control',
                            'multiple' => true,
                            'required' => true,
                        ]) !!}
                        @error('images')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                        @if ($errors->has('images.*'))
                        @foreach ($errors->get('images.*') as $messages)
                        @foreach ($messages as $message)
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @endforeach
                        @endforeach
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        {!! Form::submit('Add Item', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection