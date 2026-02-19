@extends('partials.layouts.master')

@section('title', 'Edit Island | MyTripTaylor Admin')
@section('title-sub', 'Islands')
@section('pagetitle', 'Edit Island')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Island: {{ $island->name }}</h4>
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

                <form action="{{ route('admin.islands.update', $island) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $island->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="form-label">Image URL</label>
                        <input type="text" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image', $island->image) }}" placeholder="https://...">
                    </div>

                    @if($island->cities->count() > 0)
                    <div class="mb-4">
                        <label class="form-label">Cities ({{ $island->cities->count() }})</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($island->cities as $city)
                            <span class="badge bg-info-subtle text-info fs-13 px-3 py-2">{{ $city->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Update Island</button>
                        <a href="{{ route('admin.islands.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
