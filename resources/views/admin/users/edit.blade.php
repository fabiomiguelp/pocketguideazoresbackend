@extends('partials.layouts.master')

@section('title', 'Edit User | MyTripTaylor Admin')
@section('title-sub', 'User Management')
@section('pagetitle', 'Edit User')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit User: {{ $user->name }}</h4>
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

                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password <span class="text-muted">(leave empty to keep current)</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="mb-4">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    @if($user->socialAccounts->count() > 0)
                    <div class="mb-4">
                        <label class="form-label">Linked Social Accounts</label>
                        <div class="d-flex gap-2">
                            @foreach($user->socialAccounts as $account)
                            <span class="badge bg-info-subtle text-info fs-13 px-3 py-2">
                                @if($account->provider === 'google')
                                <i class="ri-google-fill me-1"></i>
                                @elseif($account->provider === 'facebook')
                                <i class="ri-facebook-fill me-1"></i>
                                @elseif($account->provider === 'apple')
                                <i class="ri-apple-fill me-1"></i>
                                @endif
                                {{ ucfirst($account->provider) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label text-muted">Registered</label>
                        <p>{{ $user->created_at->format('M d, Y \a\t H:i') }}</p>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
