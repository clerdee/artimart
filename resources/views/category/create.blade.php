@php
use Collective\Html\FormFacade as Form;
@endphp

@extends('layouts.base')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Category</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'category.store']) !!}

                    <!-- Category Description -->
                    <div class="mb-3">
                        {!! Form::label('description', 'Category', ['class' => 'form-label fw-bold']) !!}
                        {!! Form::text('description', null, [
                            'class' => 'form-control',
                            'id' => 'description',
                            'required' => true,
                            'placeholder' => 'Enter Category',
                        ]) !!}
                        @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        {!! Form::submit('Add Category', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection