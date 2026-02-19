@extends('partials.layouts.master')

@section('title', 'Islands | MyTripTaylor Admin')
@section('title-sub', 'Trip Planner')
@section('pagetitle', 'Islands')

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
                <h4 class="card-title">Islands List</h4>
                <div class="d-flex gap-3">
                    <form action="{{ route('admin.islands.index') }}" method="GET" class="d-flex gap-3">
                        <div class="form-icon right">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            <i class="ri-search-2-line search-icon"></i>
                        </div>
                    </form>
                    <a href="{{ route('admin.islands.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>Add Island
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
                                <th>Cities</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($islands as $island)
                            <tr>
                                <td>{{ $island->id }}</td>
                                <td>
                                    <h6 class="mb-0">{{ $island->name }}</h6>
                                </td>
                                <td><span class="text-muted">{{ $island->slug }}</span></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">{{ $island->cities_count }} cities</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.islands.edit', $island) }}" class="btn btn-sm btn-light">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('admin.islands.destroy', $island) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this island?')">
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
                                <td colspan="5" class="text-center text-muted py-4">No islands found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $islands->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
