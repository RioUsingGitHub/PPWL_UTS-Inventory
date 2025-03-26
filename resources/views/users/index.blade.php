@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Users</h6>
                    @can('create-users')
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add User
                    </a>
                    @endcan
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Department</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Roles</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset('/img/team-2.jpg') }}" class="avatar avatar-sm me-3" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->department }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $user->employee_id }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @foreach($user->roles as $role)
                                        <span class="badge badge-sm bg-gradient-success">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group">
                                            @can('edit-users')
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-link text-secondary mb-0">
                                                <i class="fa fa-edit text-xs"></i>
                                            </a>
                                            @endcan
                                            @can('delete-users')
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger mb-0" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fa fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection