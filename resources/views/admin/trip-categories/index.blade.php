@extends('partials.layouts.master')

@section('title', 'Trip Categories | MyTripTaylor Admin')
@section('title-sub', 'Trip Planner')
@section('pagetitle', 'Trip Categories')

@section('content')

<div class="row">
    <div class="col-lg-12">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-header flex-wrap gap-4">
                <h4 class="card-title">Categories List</h4>
                <div class="d-flex gap-3">
                    <form action="{{ route('admin.trip-categories.index') }}" method="GET" class="d-flex gap-3">
                        <div class="form-icon right">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            <i class="ri-search-2-line search-icon"></i>
                        </div>
                    </form>
                    <a href="{{ route('admin.trip-categories.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>Add Category
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-box table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Icon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <h6 class="mb-0">{{ $category->name }}</h6>
                                </td>
                                <td><span class="text-muted">{{ $category->slug }}</span></td>
                                <td>
                                    @if($category->icon)
                                    <span class="badge bg-info-subtle text-info">{{ $category->icon }}</span>
                                    @else
                                    <span class="text-muted">None</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.trip-categories.edit', $category) }}" class="btn btn-sm btn-light">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('admin.trip-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
