@extends('layouts.app')

@section('content')
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Register Confirm') }}</div>
        <div class="card-body">
          <form method="POST" action="{{ route('register.confirm') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row mb-3">
              <label for="name" class="col-md-4 col-form-label text-end">{{ __('Name') }}</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name" readonly>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="email" class="col-md-4 col-form-label text-end">{{ __('E-Mail Address') }}</label>
              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="password" class="col-md-4 col-form-label text-end">{{ __('Password') }}</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="password-confirm" class="col-md-4 col-form-label text-end">{{ __('Confirm Password') }}</label>
              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="type" class="col-md-4 col-form-label text-end">{{ __('Type') }}</label>
              <div class="col-md-6">
                <select class="form-control hide-input" name="type" readonly="readonly">
                  <option value="{{ old('type') }}" selected>{{ old('type') == 0 ? 'Admin' : 'User' }}</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="phone" class="col-md-4 col-form-label text-end">{{ __('Phone') }}</label>
              <div class="col-md-6">
                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="dob" class="col-md-4 col-form-label text-end">{{ __('Date of Birth') }}</label>
              <div class="col-md-6">
                <input id="dob" type="date" class="form-control" name="dob" value="{{ old('dob') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="address" class="col-md-4 col-form-label text-end">{{ __('Address') }}</label>
              <div class="col-md-6">
                <textarea d="address" type="text" class="form-control" name="address" readonly="readonly">{{old('address')}}</textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-4 col-form-label text-end">{{ __('Profile') }}</label>
              <div class="col-md-6">
                <input id="profile" type="text" class="form-control hide-input mb-3" name="profile" required value="{{ session('profileName') }}" autocomplete="profile" readonly="readonly" />
                <img class="preview-profile w-25" src="{{ asset('storage/images/'.session('profileName')) }}" />
              </div>
            </div>

            <div class="form-group row mb-3">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Confirm') }}
                </button>
                <a class="cancel-btn btn btn-secondary" onClick="window.history.back()">{{ __('Cancel') }}</a>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection