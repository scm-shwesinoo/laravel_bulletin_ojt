@extends('layouts.app')

@section('content')
<script src="{{ asset('js/post-list.js') }}"></script>

<div class="container mt-5 position-relative">
  <div class="alert-message d-flex justify-content-end position-absolute top-0 end-0 z-1">
    @if(session('info'))
    <div class="alert alert-danger d-flex justify-contend-between" id="alert">
      <strong>{{ session('info') }}</strong>
      <button type="button" class="btn-close mx-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-info d-flex justify-contend-between" id="alert">
      <strong>{{ session('success') }}</strong>
      <button type="button" class="btn-close mx-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
  </div>

  <div class="row pt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Post List</div>
        <div class="card-body">
          <div class="row mb-2 search-bar d-flex justify-content-end">
            <label class="px-0 py-2 w-auto search-lbl">Keyword :</label>
            <form action="{{ route('postlist') }}" method="GET" class="w-auto d-flex p-0">
              <div class="input-group mx-2">
                <input type="text" class="form-control" type="text" name="search" value="{{ request('search') }}"
                  id="search-keyword">
                <span class="input-group-text">
                  <a class="header-btn text-secondary" href="{{ url('post/list') }}"><i
                      class="fa-solid fa-xmark"></i></a>
                </span>
              </div>
              <button class="btn btn-outline-primary mx-2 w-auto search-btn" id="search-click">Search</button>
            </form>
            @if(auth()->user() && (auth()->user()->type == 0 || auth()->user()->type == 1))
            <a class="btn btn-primary mx-2 w-auto header-btn px-3"
              href="{{ url('post/create') }}">{{ __('Create') }}</a>
            <a class="btn btn-primary mx-2 w-auto header-btn px-3" href="/post/upload">{{ __('Upload') }}</a>
            @endif
            <a class="btn btn-primary mx-2 w-auto px-3 header-btn"
              href="{{ route('downloadPostCSV', [ 'search' => request('search')]) }}">{{ __('Download') }}</a>
          </div>
          <form action="{{ route('postlist') }}" method="get" class="mb-3">
            <label for="page_size">Page Size:</label>
            <select class="form-select d-inline w-auto" name="page_size" id="page_size">
              <option value="5" @if($pageSize==5) selected @endif>5</option>
              <option value="10" @if($pageSize==10) selected @endif>10</option>
              <option value="15" @if($pageSize==15) selected @endif>15</option>
            </select>
          </form>
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="header-cell" scope="col">Post Title</th>
                <th class="header-cell" scope="col">Post Description</th>
                <th class="header-cell" scope="col">Posted User</th>
                <th class="header-cell" scope="col">Posted Date</th>
                @if(auth()->user() && (auth()->user()->type == 0 || auth()->user()->type == 1))
                <th class="header-cell" scope="col">Operation</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @if (count($postList) > 0)
              @foreach($postList as $post)
              <tr>
                <td style="width: 20%;"><a href="#" onclick="showPostDetail({{json_encode($post)}})"
                    data-bs-toggle="modal" data-bs-target="#post-detail-modal">{{$post->title}}</a></td>
                <td style="width: 40%;">{{$post->description}}</td>
                <td style="width: 12%;">{{$post->created_user}}</td>
                <td style="width: 12%;">{{date('Y/m/d', strtotime($post->created_at))}}</td>
                @if(auth()->user() && (auth()->user()->type == 0 || auth()->user()->type == 1))
                <td style="width: 15%;">
                  @if(auth()->user()->id == $post->created_user_id)
                  <a type="button" class="btn btn-primary" href="/post/edit/{{$post->id}}">Edit</a>
                  <button type="button" onclick="showDeleteConfirm({{json_encode($post)}})" class="btn btn-danger"
                    data-bs-toggle="modal" data-bs-target="#post-delete-modal">Delete</button>
                  @endif
                </td>
                @endif
              </tr>
              @endforeach
              @else
              <tr class="">
                <td colspan="5" class="text-center">Ther is no data</td>
              </tr>
              @endif
            </tbody>
          </table>
          @if (count($postList) > 0)
          <div class="d-flex justify-content-end align-items-center">
            <div class="mx-3 mb-3">
              Showing {{($postList->currentpage()-1)*$postList->perpage()+1}} to
              {{$postList->currentpage()*$postList->perpage()}}
              of {{$postList->total()}} entries
            </div>
            {{ $postList->appends(request()->all())->links() }}
          </div>

          <div class="modal fade" id="post-detail-modal" tabindex="-1" aria-labelledby="detailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{ __('Post Detail') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="post-detail">
                  <div class="col-md-12">
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('Title') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-title"></i>
                      </label>
                    </div>
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('Description') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-description"></i>
                      </label>
                    </div>
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('Status') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-status"></i>
                      </label>
                    </div>
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('Created Date') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-created-at"></i>
                      </label>
                    </div>
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('Created User') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-created-user"></i>
                      </label>
                    </div>
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('Updated Date') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-updated-at"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-start">{{ __('Updated User') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-updated-user"></i>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="post-delete-modal" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete Confirm') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/post/delete/{postId}') }}" method="POST">
                  <div class="modal-body" id="post-delete">
                    @csrf
                    @method('DELETE')
                    <input id="postId" name="postId" hidden value="">
                    <h4 class="delete-confirm-header">Are you sure to delete post?</h4>
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('ID') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-id"></i>
                      </label>
                    </div>
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('Title') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-title"></i>
                      </label>
                    </div>
                    <div class="row mb-2">
                      <label class="col-md-4 text-start">{{ __('Description') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-description"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-start">{{ __('Status') }}</label>
                      <label class="col-md-8 text-start">
                        <i class="post-text" id="post-status"></i>
                      </label>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
@endsection