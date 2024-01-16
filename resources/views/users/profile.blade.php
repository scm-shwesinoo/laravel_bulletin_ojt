@extends('layouts.app')

@section('content')
    <div class="container mt-5 position-relative">
        <div class="alert-message d-flex justify-content-end position-absolute top-0 end-0 z-1">
            @if (session('success'))
                <div class="alert alert-info d-flex justify-contend-between" id="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close mx-3" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="row justify-content-center profile-view">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-6 text-center d-flex flex-column align-items-center">
                                <div class="row img-blk position-relative mb-3">
                                    <div class="profile">
                                        <img class="preview-profile w-100"
                                            src="{{ asset('storage/images/' . $user->profile) }}" />
                                    </div>
                                    <a type="button"
                                        class="btn btn-primary rounded-circle w-auto position-absolute edit-btn"
                                        href="{{ url('/user/profile/edit') }}">
                                        {{ __('+') }}
                                    </a>
                                </div>
                                <div class="row">
                                    <label class="h4 text-start profile-text">
                                        {{ $user->name }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-12 col-sm-6">
                                <div class="row mb-3">
                                    <label class="col-md-3 text-start">{{ __('Type') }}</label>
                                    @if ($user->type == '0')
                                        <label class="col-md-9 text-start">
                                            <i class="profile-text">Admin</i>
                                        </label>
                                    @else
                                        <label class="col-md-9 text-start">
                                            <i class="profile-text">User</i>
                                        </label>
                                    @endif
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 text-start">{{ __('Email') }}</label>
                                    <label class="col-md-9 text-start">
                                        <i class="profile-text">{{ $user->email }}</i>
                                    </label>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 text-start">{{ __('Phone') }}</label>
                                    <label class="col-md-9 text-start">
                                        <i class="profile-text">{{ $user->phone }}</i>
                                    </label>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 text-start">{{ __('Date of Birth') }}</label>
                                    <label class="col-md-9 text-start">
                                        <i class="profile-text">{{ date('Y/m/d', strtotime($user->dob)) }}</i>
                                    </label>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 text-start">{{ __('Address') }}</label>
                                    <label class="col-md-9 text-start">
                                        <i class="profile-text">{{ $user->address }}</i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
