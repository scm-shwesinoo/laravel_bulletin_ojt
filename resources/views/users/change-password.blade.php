@extends('layouts.app')
@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Change Password</div>

        <div class="card-body">
          <form method="POST" action="{{ route('change.password') }}">
            @csrf

            <div class="form-group row mb-3">
              <label for="password" class="col-md-4 col-form-label text-md-end">Current Password</label>
              <div class="col-md-6">
                <input id="password" type="password"
                  class="form-control @error('current_password') is-invalid @enderror" name="current_password"
                  value="{{ old('current_password') }}" autocomplete="current-password">
                @error('current_password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>
              <div class="col-md-6">
                <input id="new_password" type="password"
                  class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                  value="{{ old('new_password') }}" autocomplete="current-password">
                @error('new_password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="password" class="col-md-4 col-form-label text-md-end">New Confirm Password</label>
              <div class="col-md-6">
                <input id="new_confirm_password" type="password"
                  class="form-control @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password"
                  value="{{ old('new_confirm_password') }}" autocomplete="current-password">
                @error('new_confirm_password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-3">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  Update Password
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection