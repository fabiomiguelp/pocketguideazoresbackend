@extends('partials.layouts.master')

@section('title', 'Edit Partner | MyTripTaylor Admin')
@section('title-sub', 'Partners')
@section('pagetitle', 'Edit Partner')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Partner: {{ $partner->name }}</h4>
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

                <form action="{{ route('admin.partners.update', $partner) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $partner->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $partner->description) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="island_id" class="form-label">Island <span class="text-danger">*</span></label>
                        <select class="form-select @error('island_id') is-invalid @enderror" id="island_id" name="island_id" required>
                            <option value="">Select Island...</option>
                            @foreach($islands as $island)
                            <option value="{{ $island->id }}" {{ old('island_id', $partner->island_id) == $island->id ? 'selected' : '' }}>{{ $island->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="trip_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('trip_category_id') is-invalid @enderror" id="trip_category_id" name="trip_category_id" required>
                            <option value="">Select Category...</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('trip_category_id', $partner->trip_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="budget_level_id" class="form-label">Budget Level <span class="text-danger">*</span></label>
                        <select class="form-select @error('budget_level_id') is-invalid @enderror" id="budget_level_id" name="budget_level_id" required>
                            <option value="">Select Budget Level...</option>
                            @foreach($budgetLevels as $bl)
                            <option value="{{ $bl->id }}" {{ old('budget_level_id', $partner->budget_level_id) == $bl->id ? 'selected' : '' }}>{{ $bl->name }} ({{ $bl->min_budget }}{{ $bl->max_budget ? '-'.$bl->max_budget : '+' }}€)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="form-label">Price (€ per person) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $partner->price) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="contact" class="form-label">Contact <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" value="{{ old('contact', $partner->contact) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link', $partner->link) }}">
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Update Partner</button>
                        <a href="{{ route('admin.partners.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
