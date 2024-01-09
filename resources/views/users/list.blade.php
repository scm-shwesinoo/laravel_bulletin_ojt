@extends('layouts.app')

@section('content')

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
        <div class="card-header">{{ __('User List') }}</div>
        <div class="card-body">
          <div class="row mb-2 search-bar">
            <form action="{{ route('userlist') }}" method="GET" class="d-flex justify-content-end">
              <label class="p-2 search-lbl w-auto">Name :</label>
              <input class="form-control search-input mb-2 mx-2 w-auto" type="text" name="search-name"
                id="search-name" />
              <label class="p-2 search-lbl w-auto">Email :</label>
              <input class="form-control search-input mb-2 mx-2 w-auto" type="text" name="search-email"
                id="search-email" />
              <label class="p-2 search-lbl w-auto">From :</label>
              <input class="form-control search-input mb-2 mx-2 w-auto" name="dateStart" id="dateStart" type="date" />
              <label class="p-2 search-lbl w-auto">To :</label>
              <input class="form-control search-input mb-2 mx-2 w-auto" name="dateEnd" id="dateEnd" type="date" />
              <button class="btn btn-primary mb-2 mx-2 w-auto search-btn" id="search-click">Search</button>
            </form>
          </div>
          <form action="" method="get" class="mb-3">
            <label for="page_size">Page Size:</label>
            <select class="form-select d-inline w-auto" name="page_size" id="page_size">
              <option value="5" @if($pageSize==5) selected @endif>5</option>
              <option value="10" @if($pageSize==10) selected @endif>10</option>
              <option value="15" @if($pageSize==15) selected @endif>15</option>
            </select>
          </form>
          <table class="table table-bordered table-hover table-responsive" id="user-list">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th class="header-cell" scope="col">Name</th>
                <th class="header-cell" scope="col">Email</th>
                <th class="header-cell" scope="col">Created User</th>
                <th class="header-cell" scope="col">Type</th>
                <th class="header-cell" scope="col">Phone</th>
                <th class="header-cell" scope="col">Date of Birth</th>
                <th class="header-cell" scope="col">Address</th>
                <th class="header-cell" scope="col">Created Date</th>
                <th class="header-cell" scope="col">Updated Date</th>
                <th class="header-cell" scope="col">Operation</th>
              </tr>
            </thead>
            <tbody>
              @if (count($userList) > 0)
              @foreach ($userList as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td>
                  <a href="#" class="user-name" onclick="User.prototype.showUserDetail({{$user}}, {{$user->createdBy}}, {{$user->updatedBy}})" data-bs-toggle="modal"
                    data-bs-target="#user-detail-modal">{{$user->name}}</a>
                </td>
                <td>{{$user->email}}</td>
                <td>{{$user->createdBy->name}}</td>
                <td>{{ $user->type == 0 ? 'Admin' : 'User' }}</td>
                <td>{{$user->phone}}</td>
                <td>{{date('Y/m/d', strtotime($user->dob))}}</td>
                <td>{{$user->address}}</td>
                <td>{{date('Y/m/d', strtotime($user->created_at))}}</td>
                <td>{{date('Y/m/d', strtotime($user->updated_at))}}</td>
                <td>
                  @if($user->id != auth()->user()->id)
                  <button type="button" class="btn btn-danger" onclick="User.prototype.showDeleteConfirm({{$user}})"
                    data-bs-toggle="modal" data-bs-target="#user-delete-modal">Delete</button>
                  @endif
                </td>
              </tr>
              @endforeach
              @else
              <tr class="">
                <td colspan="11" class="text-center">Ther is no data</td>
              </tr>
              @endif
            </tbody>
          </table>
          @if (count($userList) > 0)
          <div class="d-flex justify-content-end">
            <div class="mx-3 mb-3">
              Showing {{($userList->currentpage()-1)*$userList->perpage()+1}} to
              {{$userList->currentpage()*$userList->perpage()}}
              of {{$userList->total()}} entries
            </div>
            {{ $userList->appends(['page_size' => $pageSize])->links() }}
          </div>

          <div class="modal fade" id="user-detail-modal" tabindex="-1" aria-labelledby="detailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{ __('User Detail') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="user-detail">
                  <div class="row">
                    <div class="col-lg-3 col-md-12 col-sm-6 text-center">
                      <img id="user-profile" class="preview-profile w-100" src="" alt="Profile" />
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-6">
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Name') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-name"></i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Type') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-type">{{ $user->type == 0 ? 'Admin' : 'User' }}</i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Email') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-email"></i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Phone') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-phone"></i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Date of Birth') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-dob"></i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Address') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-address"></i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Created Date') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-created-at"></i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Created User') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-created-user"></i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Updated Date') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-updated-at"></i>
                        </label>
                      </div>
                      <div class="row mb-3">
                        <label class="col-md-4 text-start">{{ __('Updated User') }}</label>
                        <label class="col-md-8 text-start">
                          <i class="profile-text" id="user-updated-user"></i>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="user-delete-modal" tabindex="-1" aria-labelledby="detailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{ __('Delete Confirm') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  </button>
                </div>
                <form action="{{ url('/user/delete/{userId}') }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <div class="modal-body" id="user-delete">
                    <input id="userId" name="userId" value="" hidden>
                    <h4 class="delete-confirm-header">Are you sure to delete user?</h4>
                    <div class="col-md-12">
                      <div class="row mb-2">
                        <label class="col-md-3 text-md-start">{{ __('ID') }}</label>
                        <label class="col-md-9 text-md-start">
                          <i class="profile-text" id="user-id"></i>
                        </label>
                      </div>
                      <div class="row mb-2">
                        <label class="col-md-3 text-md-start">{{ __('Name') }}</label>
                        <label class="col-md-9 text-md-start">
                          <i class="profile-text" id="user-name"></i>
                        </label>
                      </div>
                      <div class="row mb-2">
                        <label class="col-md-3 text-md-start">{{ __('Type') }}</label>
                        <label class="col-md-9 text-md-start">
                          <i class="profile-text" id="user-type"></i>
                        </label>
                      </div>
                      <div class="row mb-2">
                        <label class="col-md-3 text-md-start">{{ __('Email') }}</label>
                        <label class="col-md-9 text-md-start">
                          <i class="profile-text" id="user-email"></i>
                        </label>
                      </div>
                      <div class="row mb-2">
                        <label class="col-md-3 text-md-start">{{ __('Phone') }}</label>
                        <label class="col-md-9 text-md-start">
                          <i class="profile-text" id="user-phone"></i>
                        </label>
                      </div>
                      <div class="row mb-2">
                        <label class="col-md-3 text-md-start">{{ __('DOB') }}</label>
                        <label class="col-md-9 text-md-start">
                          <i class="profile-text" id="user-dob"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-start">{{ __('Address') }}</label>
                        <label class="col-md-9 text-md-start">
                          <i class="profile-text" id="user-address"></i>
                        </label>
                      </div>
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