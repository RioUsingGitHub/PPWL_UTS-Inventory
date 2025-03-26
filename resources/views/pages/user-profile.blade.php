@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Profile</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save Changes</button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">Name</label>
                                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Employment Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department" class="form-control-label">Department</label>
                                        <input class="form-control" type="text" name="department" id="department" value="{{ old('department', auth()->user()->department) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employee_id" class="form-control-label">Employee ID</label>
                                        <input class="form-control" type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', auth()->user()->employee_id) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Change Password</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.password.update') }}">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header pb-0">
                        <h6>Role & Permissions</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-control-label">Current Roles</label>
                            <div>
                                @foreach(auth()->user()->roles as $role)
                                    <span class="badge bg-gradient-primary">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-control-label">Current Permissions</label>
                            <div>
                                @foreach(auth()->user()->getAllPermissions() as $permission)
                                    <span class="badge bg-gradient-info">{{ $permission->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
