@extends('partials.layouts.master')

@section('title', 'Hidden Gems | MyTripTaylor Admin')
@section('title-sub', 'Trip Planner')
@section('pagetitle', 'Hidden Gems')

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
                <h4 class="card-title">Hidden Gems & Local Tips</h4>
                <div class="d-flex gap-3">
                    <form action="{{ route('admin.city-gems.index') }}" method="GET" class="d-flex gap-3">
                        <div class="form-icon right">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            <i class="ri-search-2-line search-icon"></i>
                        </div>
                        <select name="island" class="form-select" style="width: auto;" onchange="this.form.submit()">
                            <option value="all" {{ request('island') === 'all' ? 'selected' : '' }}>All Islands</option>
                            @foreach($islands as $island)
                            <option value="{{ $island->id }}" {{ request('island') == $island->id ? 'selected' : '' }}>{{ $island->name }}</option>
                            @endforeach
                        </select>
                    </form>
                    <a href="{{ route('admin.city-gems.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>Add Gem
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
                                <th>City</th>
                                <th>Island</th>
                                <th>Tip</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gems as $gem)
                            <tr>
                                <td>{{ $gem->id }}</td>
                                <td>
                                    <h6 class="mb-0">{{ $gem->name }}</h6>
                                    <span class="fs-12 text-muted">{{ Str::limit($gem->description, 60) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info">{{ $gem->city->name }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success">{{ $gem->city->island->name }}</span>
                                </td>
                                <td>
                                    <span class="fs-12 text-muted">{{ $gem->tip ? Str::limit($gem->tip, 40) : '—' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.city-gems.edit', $gem) }}" class="btn btn-sm btn-light">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('admin.city-gems.destroy', $gem) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gem?')">
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
                                <td colspan="6" class="text-center text-muted py-4">No hidden gems found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $gems->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
