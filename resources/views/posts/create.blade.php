@extends('layouts.app')

@section('content')
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Create Post') }}</div>
        <div class="card-body">
          <form action="{{ route('create.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-3">
              <label for="title" class="form-label col-md-4 text-end required">{{ __('Title') }}</label>
              <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                  value="{{ old('title') }}" autocomplete="title" autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-3">
              <label for="description" class="form-label col-md-4 text-end required">{{ __('Description') }}</label>

              <div class="col-md-6">
                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                  name="description" autocomplete="description">{{ old('description') }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-3">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Create') }}
                </button>
                <button type="reset" class="btn btn-secondary">
                  {{ __('Clear') }}
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