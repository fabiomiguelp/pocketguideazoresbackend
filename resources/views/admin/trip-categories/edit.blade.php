@extends('partials.layouts.master')

@section('title', 'Edit Category | MyTripTaylor Admin')
@section('title-sub', 'Trip Categories')
@section('pagetitle', 'Edit Category')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Category: {{ $tripCategory->name }}</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('admin.trip-categories.update', $tripCategory) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tripCategory->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="icon" class="form-label">Icon Identifier</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $tripCategory->icon) }}" placeholder="e.g. star, hiking, beach">
                        <small class="text-muted">Icon name used by the Flutter app</small>
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('admin.trip-categories.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
