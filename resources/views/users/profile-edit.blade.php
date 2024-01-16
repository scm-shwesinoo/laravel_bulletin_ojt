@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile Edit') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.edit') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-end">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $user->name }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end required">{{ __('E-Mail Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $user->email }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="type" class="col-md-4 col-form-label text-md-end required"
                                    id="type">{{ __('Type') }}</label>
                                <div class="col-md-6">
                                    @if (auth()->user()->type == '0')
                                        <select class="form-select @error('type') is-invalid @enderror" name="type">
                                            <option value="0" {{ $user->type == 0 ? 'selected' : '' }}>
                                                {{ __('Admin') }}</option>
                                            <option value="1" {{ $user->type == 1 ? 'selected' : '' }}>
                                                {{ __('User') }}</option>
                                        </select>
                                    @else
                                        <select class="form-control @error('type') is-invalid @enderror" name="type"
                                            disabled>
                                            <option value="{{ $user->type }}" selected>{{ $user->type }}</option>
                                        </select>
                                    @endif
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="phone"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ $user->phone }}" autocomplete="phone">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="dob"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>
                                <div class="col-md-6">
                                    <input id="dob" type="date"
                                        class="form-control @error('dob') is-invalid @enderror" name="dob"
                                        value="{{ $user->dob }}" autocomplete="dob">
                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="address"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                                <div class="col-md-6">
                                    <textarea id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address">{{ $user->address }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="old-profile"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Old Profile') }}</label>
                                <div class="col-md-6">
                                    <img class="preview-profile w-50"
                                        src="{{ asset('storage/images/' . $user->profile) }}" />
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">{{ __('New Profile') }}</label>
                                <div class="col-md-6">
                                    <input id="profile" type="file"
                                        class="profile form-control @error('profile') is-invalid @enderror" name="profile"
                                        autocomplete="profile" />
                                    @error('profile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="mt-2" id="img-preview"></div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Edit') }}
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        {{ __('Clear') }}
                                    </button>
                                    <a class="btn btn-link" href="{{ url('/user/change-password') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
