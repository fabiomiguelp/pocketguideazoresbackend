@extends('partials.layouts.master')

@section('title', 'Edit Budget Level | MyTripTaylor Admin')
@section('title-sub', 'Budget Levels')
@section('pagetitle', 'Edit Budget Level')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Budget Level: {{ $budgetLevel->name }}</h4>
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

                <form action="{{ route('admin.budget-levels.update', $budgetLevel) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $budgetLevel->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="min_budget" class="form-label">Min Budget (EUR/day) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('min_budget') is-invalid @enderror" id="min_budget" name="min_budget" value="{{ old('min_budget', $budgetLevel->min_budget) }}" required min="0">
                    </div>
                    <div class="mb-4">
                        <label for="max_budget" class="form-label">Max Budget (EUR/day) <span class="text-muted">(leave empty for unlimited)</span></label>
                        <input type="number" class="form-control @error('max_budget') is-invalid @enderror" id="max_budget" name="max_budget" value="{{ old('max_budget', $budgetLevel->max_budget) }}" min="0">
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Update Budget Level</button>
                        <a href="{{ route('admin.budget-levels.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
