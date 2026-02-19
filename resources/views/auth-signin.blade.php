@extends('partials.layouts.master_auth')

@section('title', 'Sign In | MyTripTaylor Admin')

@section('content')

<div class="container">
  <div class="row justify-content-center align-items-center min-vh-100 pt-20 pb-10">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
      <div class="card mx-xxl-8 shadow-none">
        <div class="card-body p-8">
          <h3 class="fw-medium text-center">Welcome back!</h3>
          <p class="mb-8 text-muted text-center">Sign in to your admin account</p>

          @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
              <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
            </div>
            <div class="mb-4">
              <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
              <div class="position-relative">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                <button type="button" class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted toggle-password" id="toggle-password" data-target="password"><i class="ri-eye-off-line align-middle"></i></button>
              </div>
            </div>
            <div class="my-6">
              <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                  <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <div class="form-text">
                  <a href="auth-forgot-password" class="link">Forgot password?</a>
                </div>
              </div>
            </div>
            <div>
              <button type="submit" class="btn btn-primary w-100 mb-4">Sign In</button>
            </div>
          </form>
        </div>
      </div>
      <p class="position-relative text-center fs-13 mb-0">&copy;
        <script>document.write(new Date().getFullYear())</script> MyTripTaylor
      </p>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/js/auth/auth.init.js') }}"></script>
@endsection
