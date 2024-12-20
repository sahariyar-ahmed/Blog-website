@extends('layouts.dashboardmaster')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Existing User Role Management</h4>

                <form role="form" action="{{route('management.role.assign')}}" method="POST" >
                    @csrf
                   
                    <div class="row mb-2">
                        <label for="inputPassword5" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="role" >
                                <option value="">Select roles</option>
                                <option value="manager">Manager</option>
                                <option value="blogger">Blogger</option>
                                <option value="user">User</option>

                            </select>
                            @error('role')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="inputPassword5" class="col-sm-3 col-form-label">Manage users</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="user_id" >
                                <option value="">Select roles</option>
                                @foreach ($dedsec as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach

                            </select>
                            @error('role')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="justify-content-end row">
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-info waves-effect waves-light">Enter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Management Table</h4>
                <p class="sub-header">
                    Use one of two modifier classes to make <code>&lt;thead&gt;</code>s appear light or dark gray.
                </p>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
                                @if (Auth::user()->role == 'admin' )
                                <th>Status</th>
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $red as $blogger )
                            <tr>
                                <th scope="row">
                                    {{$loop->index + 1}}
                                </th>

                                <td>{{ $blogger->name }}</td>
                                <td>{{ $blogger->role }}</td>
                                @if (Auth::user()->role == 'admin')

                                <td>
                                    <form id="hulkuser{{$blogger->id}}" action="{{route('management.role.blogger.down',$blogger->id)}}" method="POST">
                                        @csrf
                                        <div class="form-check form-switch">
                                            <input onchange="document.querySelector('#hulkuser{{$blogger->id}}').submit()" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $blogger->role == $blogger->role ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">{{ $blogger->role }}</label>

                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <a href="" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                                @endif
                            </tr>

                            @empty
                            <tr>
                                <td colspan="5" class="text-danger text-center">No blogger found</td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->
            </div>
        </div> <!-- end card -->
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">User's Table</h4>
                <p class="sub-header">
                    Use one of two modifier classes to make <code>&lt;thead&gt;</code>s appear light or dark gray.
                </p>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
                                @if (Auth::user()->role == 'admin' )
                                <th>Status</th>
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $dedsec as $user )
                            <tr>
                                <th scope="row">
                                    {{$loop->index + 1}}
                                </th>

                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role }}</td>
                                @if (Auth::user()->role == 'admin')

                                <td>
                                    <form id="hulkuser{{$user->id}}" action="{{route('management.role.user.down',$user->id)}}" method="POST">
                                        @csrf
                                        <div class="form-check form-switch">
                                            <input onchange="document.querySelector('#hulkuser{{$user->id}}').submit()" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $user->role == $user->role ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">{{ $user->role }}</label>

                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <a href="" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-danger text-center">No user found</td>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->
            </div>
        </div> <!-- end card -->
    </div>
</div>

@endsection


@section('script')
@if (session('assignrole'))


<script>
    Toastify({
    text: "{{session('assignrole')}}",
    duration: 3000,
    newWindow: true,
    close: true,
    gravity: "top", // `top` or `bottom`
    position: "right", // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
    style: {
        background: "linear-gradient(to right, #00b09b, #96c93d)",
    },
    onClick: function(){} // Callback after click
    }).showToast();
</script>
@endif
@endsection
