@extends('partials.layouts.master')

@section('title', 'Create City | MyTripTaylor Admin')
@section('title-sub', 'Cities')
@section('pagetitle', 'Create City')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create New City</h4>
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

                <form action="{{ route('admin.cities.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="island_id" class="form-label">Island <span class="text-danger">*</span></label>
                        <select class="form-select @error('island_id') is-invalid @enderror" id="island_id" name="island_id" required>
                            <option value="">Select Island...</option>
                            @foreach($islands as $island)
                            <option value="{{ $island->id }}" {{ old('island_id') == $island->id ? 'selected' : '' }}>{{ $island->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Create City</button>
                        <a href="{{ route('admin.cities.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
