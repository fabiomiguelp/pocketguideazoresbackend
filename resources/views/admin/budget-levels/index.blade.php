@extends('partials.layouts.master')

@section('title', 'Budget Levels | MyTripTaylor Admin')
@section('title-sub', 'Trip Planner')
@section('pagetitle', 'Budget Levels')

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
                <h4 class="card-title">Budget Levels List</h4>
                <div class="d-flex gap-3">
                    <a href="{{ route('admin.budget-levels.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i>Add Budget Level
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
                                <th>Budget Range</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($budgetLevels as $level)
                            <tr>
                                <td>{{ $level->id }}</td>
                                <td>
                                    <h6 class="mb-0">{{ $level->name }}</h6>
                                </td>
                                <td><span class="text-muted">{{ $level->slug }}</span></td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning">
                                        {{ $level->min_budget }}{{ $level->max_budget ? ' - ' . $level->max_budget : '+' }} EUR/day
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.budget-levels.edit', $level) }}" class="btn btn-sm btn-light">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('admin.budget-levels.destroy', $level) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this budget level?')">
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
                                <td colspan="5" class="text-center text-muted py-4">No budget levels found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $budgetLevels->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
