<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-roles', ['only' => ['index', 'show']]);
    }

    public function index()
    {
        $roles = Role::with('permissions')->latest()->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return view('roles.show', compact('role'));
    }
}