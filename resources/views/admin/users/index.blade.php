@extends('partials.layouts.master')

@section('title', 'User Management | MyTripTaylor Admin')
@section('title-sub', 'Admin')
@section('pagetitle', 'User Management')

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
                <h4 class="card-title">Users List</h4>
                <div class="d-flex gap-3">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex gap-3">
                        <div class="form-icon right">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            <i class="ri-search-2-line search-icon"></i>
                        </div>
                        <select name="role" class="form-select" style="width: auto;" onchange="this.form.submit()">
                            <option value="all" {{ request('role') === 'all' ? 'selected' : '' }}>All Roles</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </form>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="ri-user-add-line me-1"></i>Add User
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-box table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Social Accounts</th>
                                <th>Registered</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="d-flex align-items-center gap-3">
                                    @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="avatar-md rounded-pill">
                                    @else
                                    <div class="avatar-md rounded-pill bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-semibold">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <p class="fs-12 mb-0 text-muted">{{ $user->email }}</p>
                                    </div>
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                    <span class="badge bg-danger-subtle text-danger">Admin</span>
                                    @else
                                    <span class="badge bg-primary-subtle text-primary">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->social_accounts_count > 0)
                                    <span class="badge bg-success-subtle text-success">{{ $user->social_accounts_count }} linked</span>
                                    @else
                                    <span class="text-muted">None</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
