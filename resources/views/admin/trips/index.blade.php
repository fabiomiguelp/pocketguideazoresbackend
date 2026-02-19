@extends('partials.layouts.master')

@section('title', 'Trips | MyTripTaylor Admin')
@section('title-sub', 'Trip Planner')
@section('pagetitle', 'Trips')

@section('content')

<div class="row">
    <div class="col-lg-12">

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-header flex-wrap gap-4">
                <h4 class="card-title">All Trip Requests</h4>
                <div class="d-flex gap-3">
                    <form action="{{ route('admin.trips.index') }}" method="GET" class="d-flex gap-3">
                        <div class="form-icon right">
                            <input type="text" name="search" class="form-control" placeholder="Search user..." value="{{ request('search') }}">
                            <i class="ri-search-2-line search-icon"></i>
                        </div>
                        <select name="island" class="form-select" style="width: auto;" onchange="this.form.submit()">
                            <option value="all" {{ request('island') === 'all' ? 'selected' : '' }}>All Islands</option>
                            @foreach($islands as $island)
                            <option value="{{ $island->id }}" {{ request('island') == $island->id ? 'selected' : '' }}>{{ $island->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-box table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Island</th>
                                <th>City (Hotel)</th>
                                <th>Categories</th>
                                <th>Budget</th>
                                <th>Travelers</th>
                                <th>Days</th>
                                <th>Car</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trips as $trip)
                            <tr>
                                <td>{{ $trip->id }}</td>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $trip->user->name }}</h6>
                                        <p class="fs-12 mb-0 text-muted">{{ $trip->user->email }}</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">{{ $trip->island->name }}</span>
                                </td>
                                <td>{{ $trip->city->name }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($trip->categories as $category)
                                        <span class="badge bg-info-subtle text-info">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning">{{ $trip->budgetLevel->name }}</span>
                                </td>
                                <td>
                                    <span class="fs-13">{{ $trip->num_adults }}A</span>
                                    @if($trip->num_children > 0)
                                    <span class="fs-13 text-muted">+ {{ $trip->num_children }}C</span>
                                    @endif
                                </td>
                                <td>{{ $trip->duration_days }}</td>
                                <td>
                                    @if($trip->has_car)
                                    <span class="badge bg-success-subtle text-success">Yes</span>
                                    @else
                                    <span class="badge bg-secondary-subtle text-secondary">No</span>
                                    @endif
                                </td>
                                <td>{{ $trip->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.trips.show', $trip) }}" class="btn btn-sm btn-light">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip?')">
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
                                <td colspan="11" class="text-center text-muted py-4">No trips found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $trips->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
